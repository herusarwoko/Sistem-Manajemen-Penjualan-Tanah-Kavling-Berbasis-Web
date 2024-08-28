  <?php 
    $stt_1 = $this->db->query("SELECT * FROM kavling_peta WHERE status='1'")->num_rows();
    $stt_2 = $this->db->query("SELECT * FROM kavling_peta WHERE status='2'")->num_rows();
    $stt_3 = $this->db->query("SELECT * FROM kavling_peta WHERE status='3'")->num_rows();
    $stt_0 = $this->db->query("SELECT * FROM kavling_peta")->num_rows();
  
    $kosong = $stt_0 - ($stt_1 + $stt_2 + $stt_3);

    $terjual = $stt_2 + $stt_3;
    $customer = $this->db->query("SELECT * FROM customer")->num_rows();
    $pemasukan = $this->db->query("SELECT sum(jumlah_bayar) as jumlah FROM pembayaran")->row_array();
    $pengeluaran = $this->db->query("SELECT sum(sub_total) as jumlah FROM pengeluaran")->row_array();
    
    ?>
    
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

        <div class="row">
          
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Kavling Terjual</span>
                <span class="info-box-number"><?=$terjual;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->


          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pemasukan</span>
                <span class="info-box-number"><?=rupiah($pemasukan['jumlah']);?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->


          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pengeluaran</span>
                <span class="info-box-number"><?=rupiah($pengeluaran['jumlah']);?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Saldo</span>
                <span class="info-box-number"><?=rupiah($saldo = $pemasukan['jumlah'] - $pengeluaran['jumlah']);?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
          
          
          

      <div class="card">

        <!-- /.card-header -->
        <div class="card-body">
            <h3 class="m-0 text-dark">Laporan Periode</h3>
            <hr>
          <form action="<?=base_url('laporan/tampil');?>" target="_blank" id="form" class="form-horizontal" method="POST">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

                    <div class="form-group row">
                            <label class="control-label col-md-3">Kategori</label>
                            <div class="col-md-3">
                                <select name="jenis" class="form-control">
                                  <option value="">-- Pilih --</option>
                                  <option value="1">Pemasukan</option>
                                  <option value="2">Pengeluaran</option>
                                  <option value="3">Lengkap</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Periode Awal</label>
                            <div class="col-md-3">
                                <input name="awal" placeholder="" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Periode Akhir</label>
                            <div class="col-md-3">
                                <input name="akhir" placeholder="" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
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



<script src="<?php echo base_url('assets/admin/plugins/select2/select2.min.js')?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/plugins/select2/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/plugins/select2/select2-bootstrap.css') ?>">

<script type="text/javascript">

var url_apps = "<?=base_url();?>"

$(document).ready(function () {
//----->
//Ambil semua data customer untuk select 2
  $("#customer").select2({
    ajax: {
      url: url_apps+'transaksi/ajax_select_customer',
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params, // search term
        };
      },
      results: function (data, params) {
        console.log(data);
        return {
            results: $.map(data, function (item) {
                return {
                    text: item.nama_lengkap,
                    id: item.id_customer
                }
            })
        };
      },
      cache: true
    },
    minimumInputLength: 1,
  });  
});





$(document).ready(function () {
//----->
//Ambil semua data customer untuk select 2
  $("#kode_kavling").select2({
    ajax: {
      url: url_apps+'transaksi/ajax_select_kavling',
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params, // search term
        };
      },
      results: function (data, params) {
        console.log(data);
        return {
            results: $.map(data, function (item) {
                return {
                    text: item.kode_kavling,
                    id: item.id_kavling
                }
            })
        };
      },
      cache: true
    },
    minimumInputLength: 1,
  });  
});





</script>


