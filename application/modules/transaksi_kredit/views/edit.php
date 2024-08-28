  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Transaksi Pembelian</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <!-- Main content -->
    <section class="content">
      <div class="card">

        <!-- /.card-header -->
        <div class="card-body">

          <form action="<?=base_url('transaksi/update');?>" id="form" class="form-horizontal" method="POST">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal</label>
                            <div class="col-md-3">
                                <input name="tanggal" value="<?=$transaksi['tgl_pembelian'];?>" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

    
                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Customer</label>
                            <div class="col-md-3">
                                <input name="customer" value="<?=$transaksi['nama_lengkap'];?>" class="form-control" type="text" id="customer">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-3">
                                <input name="kode_kavling" value="<?=$transaksi['kode_kavling'];?>" class="form-control" type="text" id="kode_kavling">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Jenis Transaksi</label>
                            <div class="col-md-3">
                                <select name="jenis" class="form-control">
                                  <option value="1" <?php if ($transaksi['jenis_pembelian'] == '1') { echo 'selected';
} else {echo '';}?>>Booking</option>
                                  <option value="2" <?php if ($transaksi['jenis_pembelian'] == '2') { echo 'selected';
} else {echo '';}?>>Pembelian Cash</option>
                                  <option value="3" <?php if ($transaksi['jenis_pembelian'] == '3') { echo 'selected';
} else {echo '';}?>>Pembelian Kredit</option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Jual</label>
                            <div class="col-md-4">
                                <input name="harga_jual" id="harga_jual"  value="<?=rupiah($transaksi['harga_jual']);?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                         <div class="form-group row">
                            <label class="control-label col-md-3">DP</label>
                            <div class="col-md-4">
                                <input name="dp" id="dp" value="<?=rupiah($transaksi['jumlah_dp']);?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                         <div class="form-group row">
                            <label class="control-label col-md-3">Lama Cicilan</label>
                            <div class="col-md-4">
                                <input name="lama_cicilan" value="<?=rupiah($transaksi['lama_cicilan']);?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                         <div class="form-group row">
                            <label class="control-label col-md-3">Cicilan Per Bulan</label>
                            <div class="col-md-4">
                                <input name="cicilan_per_bulan" value="<?=rupiah($transaksi['cicilan_per_bulan']);?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-md" type="submit" name="submit"> Simpan</button>
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

    $('#harga_jual').on('change', function() {

        var myStr = $(this).val();
        var newStr = myStr.replace(/\D/g,'');
        $('#harga_jual_int').val(newStr);

    });

    $('#dp').on('change', function() {

        var myStr = $(this).val();
        var newStr = myStr.replace(/\D/g,'');
        $('#dp_int').val(newStr);

    });

    $('#cicilan_per_bulan').on('change', function() {

      var myStr = $(this).val();
      var newStr = myStr.replace(/\D/g,'');
      $('#cicilan_per_bulan_int').val(newStr);

    });


/* Tanpa Rupiah */
var harga_jual = document.getElementById('harga_jual');
  harga_jual.addEventListener('keyup', function(e) {
  harga_jual.value = formatRupiah(this.value);
});

var dp = document.getElementById('dp');
dp.addEventListener('keyup', function(e) {  
  dp.value = formatRupiah(this.value);
});

var cicilan_per_bulan = document.getElementById('cicilan_per_bulan');
  cicilan_per_bulan.addEventListener('keyup', function(e) {
  cicilan_per_bulan.value = formatRupiah(this.value);
});

harga_jual.addEventListener('keydown', function(event) {
limitCharacter(event);
});



/* Fungsi */
function formatRupiah(bilangan, prefix) {
var number_string = bilangan.replace(/[^,\d]/g, '').toString(),
  split = number_string.split(','),
  sisa = split[0].length % 3,
  rupiah = split[0].substr(0, sisa),
  ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

if (ribuan) {
  separator = sisa ? '.' : '';
  rupiah += separator + ribuan.join('.');
}

rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function limitCharacter(event) {
key = event.which || event.keyCode;
if (key != 188 // Comma
  &&
  key != 8 // Backspace
  &&
  key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
  &&
  (key < 48 || key > 57) // Non digit
  // Dan masih banyak lagi seperti tombol del, panah kiri dan kanan, tombol tab, dll
) {
  event.preventDefault();
  return false;
}
}


</script>
