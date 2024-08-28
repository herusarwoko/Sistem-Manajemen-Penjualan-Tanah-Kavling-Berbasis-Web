  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Transaksi Pembelian</h1>
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

          <form action="<?=base_url('transaksi/baru');?>" id="form" class="form-horizontal" method="POST">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal</label>
                            <div class="col-md-3">
                                <input name="tanggal" placeholder="" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

    
                        <div class="form-group row">
                            <label class="control-label col-md-3">Nama Customer</label>
                            <div class="col-md-3">
                                <input name="customer" placeholder="" class="form-control" type="text" id="customer">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-3">
                                <input name="kode_kavling" placeholder="" class="form-control" type="text" id="kode_kavling">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Jenis Transaksi</label>
                            <div class="col-md-3">
                                <select name="jenis" class="form-control">
                                  <option value="0">Pilih</option>
                                  <option value="1">Booking</option>
                                  <option value="2">Pembelian Cash</option>
                                  <option value="3">Pembelian Kredit</option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Jual</label>
                            <div class="col-md-4">
                                <input name="harga_jual" id="harga_jual" class="form-control" type="text" value="<?=$harga_jual;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>


                         <div class="form-group row">
                            <label class="control-label col-md-3">DP / Pembayaran Cash</label>
                            <div class="col-md-4">
                                <input name="dp" id="dp" class="form-control" type="text"  value="<?=$dp;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>


                         <div class="form-group row">
                            <label class="control-label col-md-3">Lama Cicilan</label>
                            <div class="col-md-4">
                                <input name="lama_cicilan" id="lama_cicilan" class="form-control" type="text"  value="<?=$lama_cicilan;?>">
                                <span class="help-block"></span>
                            </div>
                        </div>


                         <div class="form-group row">
                            <label class="control-label col-md-3">Cicilan Per Bulan</label>
                            <div class="col-md-4">
                                <input name="cicilan_per_bulan" id="cicilan_per_bulan" class="form-control" type="text" value="<?=$cicilan_per_bulan;?>">
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


$('#nama_barang').on('change', function() {
  var idSiswa = $(this).val();
  $.ajax({
    url: url_apps + 'adm_penerimaanbarang/get_barang/' + $(this).val(),
    type: 'GET',
    dataType: 'json',
  })
  .done(function(data) {
    //alert(data.ALAMAT);
    // alert('asd');
    $("#nama_barang_real").val(data.nama_barang);


    // $('#nama_siswa').val(data.nama_siswa);
    // $('#id_siswa').val(data.id_siswa);
    // $('#kode_kelas').val(data.kode_kelas);
    // var jdept = data.deposit;
    // $('#jumlah_deposit').val(jdept.toLocaleString());
    // document.getElementById("jenis").disabled = false;
    // document.getElementById("jumlah_dana").disabled = false;
    // document.getElementById("pembayaran_bulan").disabled = false;
    // document.getElementById("keterangan").disabled = false;
    // document.getElementById("potongan_persen").disabled = false;
    // document.getElementById("potongan_rupiah").disabled = false;
    // document.getElementById("tambahbaris").disabled = false;
    // $("#historyBayarTahunan").load('<?php echo base_url('penerimaan/historyBayarTahunan/');?>'+ idSiswa);
    // $("#historyBayarSPP").load('<?php echo base_url('penerimaan/historyBayarSPP/');?>'+ idSiswa);
    
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
});



</script>


