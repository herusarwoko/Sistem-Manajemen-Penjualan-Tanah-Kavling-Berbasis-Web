  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Pembayaran Cicilan</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <!-- Main content -->
    <section class="content">
      <div class="card">

      <div class="card-header">
          <h3 class="card-title">History Pembayaran : <b><?=$cust['nama_lengkap'];?> # <?=$cust['kode_kavling'];?></b></h3>
              <div class="card-tools">
                <a href="#" class="btn btn-warning btn-sm" onclick="add()"><i class="fa fa-plus"></i>  Pembayaran Baru</a>&nbsp;
                <a href="#" class="btn btn-danger btn-sm" onclick="pembatalan()"><i class="fa fa-minus"></i>  Pembatalan Pembelian</a>&nbsp;
              </div>
              <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->

        <!-- /.card-header -->
        <div class="card-body">

           <div class="row">
            <div class="col-sm-5">           
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">

              <!-- /.card-header -->

              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <tbody>

                      <tr>
                        <td width="20%">No. Telp</td>
                        <td width="80%" align="right"><?=$cust['no_telp'];?></td>
                      </tr>
                      <tr>
                        <td>Alamat</td>
                        <td  align="right"><?=$cust['alamat'];?></td>
                      </tr>
                      <tr>
                        <td >Lokasi Kavling</td>
                        <td align="right"><?=$cust['kode_kavling'];?></td>
                        <input type="hidden" name="id_kavling" id="id_kavling" value="<?=$cust['id_kavling'];?>">
                      </tr>
                      <tr>
                        <td >Jenis Pembelian</td>
                        <td align="right"><span class="badge badge-success"> 
                          <?php if($cust['status'] == '2'){
                            echo 'Pembelian Cash';
                          }elseif($cust['status'] == '3'){
                            echo 'Pembelian Kredit';
                          };?></span></td>
                      </tr>
                      <!-- <tr>
                        <td >Harga Jual</td>
                        <td align="right"><span class="badge badge-success"><?=rupiah($cust['harga_jual']);?></span></td>
                      </tr> -->
                      <tr>
                        <td >Uang Muka</td>
                        <td align="right"><span class="badge badge-success"><?=rupiah($cust['jumlah_dp']);?></span></td>
                      </tr>
                      <tr>
                        <td >Lama Cicilan</td>
                        <td align="right"><span class="badge badge-success"><?=$cust['lama_cicilan'];?></span></td>
                      </tr>
                      <tr>
                        <td >Cicilan Per Bulan</td>
                        <td align="right"><span class="badge badge-success"><?=rupiah($cust['cicilan_per_bulan']);?></span></td>
                      </tr>
                      <?php 
                      $totHutang = $cust['jumlah_dp'] + ($cust['lama_cicilan'] * $cust['cicilan_per_bulan']);
                      ?>
                      <tr>
                        <td >Harga Jual</td>
                        <td align="right"><span class="badge badge-primary"><?=rupiah($totHutang);?></span></td>
                      </tr>
                      <?php 
                      $totalBayar = $this->db->query("SELECT SUM(jumlah_bayar) as tot FROM pembayaran WHERE id_kavling='$id_kavling'")->row_array();
                      ?>
                      <tr>
                        <td >Sudah Terbayar</td>
                        <td align="right"><span class="badge badge-warning"><?=rupiah($totalBayar['tot']);?></span></td>
                      </tr>
                      <tr>
                        <td >Sisa Hutang</td>
                        <td align="right"><span class="badge badge-danger"><?=rupiah($totHutang - $totalBayar['tot']);?></span></td>
                      </tr>

                      <tr>
                        <td >Cetak Rekap Pembayaran </td>
                        <td align="right">
                        <a class="btn btn-primary btn-sm" href="<?=base_url('pembayaran/cetak_rekap/'.$cust['id_kavling']);?>" target="_blank">Cetak</a>
                        </td>
                      </tr>
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>



         <div class="col-sm-7">
    <table class="table table-bordered">
        <tr>
            <th width="15%">Cicilan</th>
            <th width="25%">Tanggal Bayar</th>
            <th width="20%">Jumlah Bayar</th>
            <th width="20%">Sisa Hutang</th>
            <th width="10%">Bukti Pembayaran</th>
            <th width="20%">Action</th>
        </tr>

        <tr>
            <td>Uang Muka</td>
            <td>
                <?php
                //cek pembayaran DP di tabel pembayaran (cicilan ke 0)
                $idCust = $cust['id_customer'];
                $cekDP = $this->db->query("SELECT * FROM pembayaran WHERE id_kavling='$id_kavling' AND pembayaran_ke='0'")->row_array();
                echo tgl_indo($cekDP['tanggal']);
                ?>
            </td>
            <td align="right"><?= rupiah($cekDP['jumlah_bayar']); ?></td>
            <td align="right"><?= rupiah($sisa = $totHutang - $cekDP['jumlah_bayar']); ?></td>
            <td></td>
            <td></td>
        </tr>

        <?php
        // cek sudah berapa kali bayar
        $kaliBayar = $this->db->query("SELECT MAX(pembayaran_ke) as kali FROM pembayaran WHERE id_kavling='$id_kavling'")->row_array();
        for ($i = 1; $i <= $kaliBayar['kali']; $i++) {

            //Cek apakah cicilan bulan $i sudah terbayar
            $query = "SELECT * FROM pembayaran WHERE pembayaran_ke='$i' AND id_kavling='$id_kavling'";
            $bayar = $this->db->query($query)->row_array();
            $link_kirim = $bayar['id_pembayaran'];
            ?>
            <tr>
                <td>Cicilan ke <?= $i ?></td>
                <td><?= tgl_indo($bayar['tanggal']) ?></td>
                <td align="right"><?= rupiah($bayar['jumlah_bayar']) ?></td>
                <td align="right"><?= rupiah($sisa = $sisa - $bayar['jumlah_bayar']) ?></td>
                <td>
                    <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalBukti<?= $bayar['id_pembayaran']; ?>">Lihat Bukti</a>
                </td>
                <td>
                    <a class="btn btn-primary btn-xs" href="<?= base_url('pembayaran/cetak/' . $bayar['id_pembayaran']) ?>" target="_blank">Download</a>
                </td>
            </tr>

            <!-- Modal untuk menampilkan gambar bukti pembayaran -->
            <div class="modal fade" id="modalBukti<?= $bayar['id_pembayaran']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalBuktiLabel<?= $bayar['id_pembayaran']; ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalBuktiLabel<?= $bayar['id_pembayaran']; ?>">Bukti Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Tambahkan tag img untuk menampilkan gambar bukti pembayaran -->
                            <img src="<?= base_url('assets/bukti_trx/bayar_angsuran/' . $bayar['bukti_pembayaran']) ?>" class="img-fluid" alt="Bukti Pembayaran">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </table>
</div>


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
                            <div class="col-md-3">
                                <input name="tanggal_bayar" value="<?=date('Y-m-d');?>" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Lengkap</label>
                            <div class="col-md-6">
                                <input name="nama_lengkap" value="<?=$cust['nama_lengkap'];?>" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-3">
                                <input name="kode_kavling" value="<?=$cust['kode_kavling'];?>" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Pembayaran Ke</label>
                            <div class="col-md-1">
                                <input name="pembayaran_ke" value="<?=$pembayaranKe;?>" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Jumlah Bayar</label>
                            <div class="col-md-3">
                                <input name="jumlah_bayar" id="jumlah_bayar" value="<?=rupiah($cust['cicilan_per_bulan']);?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                       
                        <div class="form-group row">
                            <label class="control-label col-md-3">Metode Bayar</label>
                            <div class="col-md-3">
                                <select class="form-control" name="rekening" id="rekening">
                                  <option value="">-- pilih --</option>
                                  <?php 
                                  foreach($rekening as $rek){
                                    echo '<option value="'.$rek->bank_id.'">'.$rek->bank_nama.'</option>';
                                  }
                                  ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                        <label for="bukti_pembayaran" class="control-label col-md-4">Upload Bukti Pembayaran:</label>
                          <div class="col-md-3">
                              <input name="bukti_pembayaran" id="bukti_pembayaran" class="form-control-file" type="file" size="20">
                              <span class="help-block"></span>
                          </div>
                        </div>

                      

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="bayar(<?=$pembayaranKe;?>)" class="btn btn-primary">Proses Pembayaran</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->









<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_pembatalan" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_balikin" class="form-horizontal">
                    <div class="form-body">

                    <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal Pembatalan</label>
                            <div class="col-md-3">
                                <input name="tanggal_bayar" value="<?=date('Y-m-d');?>" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Lengkap</label>
                            <div class="col-md-6">
                                <input name="nama_lengkap" value="<?=$cust['nama_lengkap'];?>" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-3">
                                <input name="kode_kavling" value="<?=$cust['kode_kavling'];?>" class="form-control" type="text" readonly>
                                <input type="hidden" name="id_kavling" id="id_kavling" value="<?=$cust['id_kavling'];?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Pembayaran Masuk</label>
                            <div class="col-md-4">
                                <input name="dana_masuk" value="<?=rupiah($totalBayar['tot']);?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Potongan Administrasi</label>
                            <div class="col-md-4">
                                <input name="biaya_admin" id="biaya_admin" value="0" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Jumlah Pengembalian</label>
                            <div class="col-md-4">
                                <input name="jumlah_pengembalian" id="jumlah_pengembalian" value="0" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                       
                        <div class="form-group row">
                            <label class="control-label col-md-3">Metode Pengembalian</label>
                            <div class="col-md-3">
                                <select class="form-control" name="rekening" id="rekening">
                                  <option value="">-- pilih --</option>
                                  <?php 
                                  foreach($rekening as $rek){
                                    echo '<option value="'.$rek->bank_id.'">'.$rek->bank_nama.'</option>';
                                  }
                                  ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                      

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="balikin(<?=$pembayaranKe;?>)" class="btn btn-primary">Proses Pengembalian</button>
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
  var idKavling = document.getElementById("id_kavling").value;
  var url       = "<?php echo site_url(); ?>";

  function add()
   {
       save_method = 'add';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form').modal('show'); // show bootstrap modal
       $('.modal-title').text('Bayar Cicilan'); // Set Title to Bootstrap modal title
   }

   function pembatalan()
   {
       save_method = 'add';
       $('#form_balikin')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form_pembatalan').modal('show'); // show bootstrap modal
       $('.modal-title').text('Pembatalan Pembelian'); // Set Title to Bootstrap modal title
   }


   function bayar(cicilanke)
   {
    var jumBayar = document.getElementById("jumlah_bayar").value;
      url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_bayar')?>/" + cicilanke + '/' + idKavling + '/' + jumBayar;

    
       // ajax adding data to database
       var formData = new FormData($('#form')[0]);
    $.confirm({
      title: 'Peringatan!',
      content: 'Apakah melakukan proses pembayaran?',
      buttons: {
        Bayar: function () {

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
   },
        Tidak: function () {
          
        }
      }
    });
  }



  function balikin()
   {
    var jumBayar = document.getElementById("jumlah_bayar").value;
      url = "<?php echo site_url($data_ref['uri_controllers'].'/balikin')?>";
      var link = "<?=base_url();?>";

    
       // ajax adding data to database
       var formData = new FormData($('#form_balikin')[0]);
    $.confirm({
      title: 'Peringatan!',
      content: 'Apakah mau melakukan pengembalian dana?',
      buttons: {
        Bayar: function () {

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
                  //  location.reload(); 
                   window.location.replace(link + 'denahtrx');
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
   },
        Tidak: function () {
          
        }
      }
    });
  }

  function kirim(id){
    $.confirm({
      title: 'Perhatian!',
      content: 'Apakah anda yakin akan mengirim pesan dan lampiran ?',
      buttons: {
        confirm: function () {
           $.ajax({
              url : url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_kirim/" + id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                  Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Pesan Berhasil Dikirim....'
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


