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

          <div class="row">
            <div class="col-md-6">
              <form action="<?=base_url('transaksi/baru');?>" id="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" value="" name="id" />
                <div class="form-body">

                  <div class="form-group row">
                    <label class="control-label col-md-4">Kode Kavling</label>
                    <div class="col-md-2">
                      <input name="kode_kavling" value="<?=$kav['kode_kavling'];?>" class="form-control" type="text"
                        readonly>
                      <input name="id_kavling" value="<?=$kav['id_kavling'];?>" class="form-control" type="hidden"
                        readonly>
                      <span class="help-block"></span>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="control-label col-md-4">Harga Jual Cash</label>
                    <div class="col-md-4">
                      <input name="harga_jual" id="harga_jual" class="form-control" type="text"
                        value="<?=rupiah($kav['hrg_jual']);?>" readonly>
                      <span class="help-block"></span>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="control-label col-md-4">Tanggal Transaksi</label>
                    <div class="col-md-4">
                      <input name="tanggal" placeholder="" class="form-control" type="date" required>
                      <span class="help-block"></span>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="control-label col-md-4">Jenis Transaksi</label>
                    <div class="col-md-4">
                      <select name="jenis" id="jenis" class="form-control" onchange="myFunction()">
                        <option value="0">Pilih</option>
                        <option value="1">Booking</option>
                        <option value="2">Pembelian Cash</option>
                        <option value="3">Pembelian Kredit</option>
                      </select>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="control-label col-md-4">Nama Customer</label>
                    <div class="col-md-6">
                      <input name="customer" placeholder="" class="form-control" type="text" id="customer">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-4">Marketing</label>
                    <div class="col-md-6">
                      <input name="marketing" placeholder="" class="form-control" type="text" id="marketing">
                      <span class="help-block"></span>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="control-label col-md-4">Fee Marketing</label>
                    <div class="col-md-4">
                      <input name="fee_marketing" id="fee_marketing" class="form-control" type="text">
                      <span class="help-block"></span>
                    </div>
                  </div>

                  <!-- <div class="form-group row">
                    <label class="control-label col-md-4">Fee Notaris</label>
                    <div class="col-md-4">
                      <input name="fee_notaris" id="fee_notaris" class="form-control" type="text">
                      <span class="help-block"></span>
                    </div>
                  </div> -->

                  <div class="form-group row">
                      <label for="bukti_pembayaran" class="control-label col-md-4">Upload Bukti Pembayaran:</label>
                      <div class="col-md-6">
                          <input name="bukti_pembayaran" id="bukti_pembayaran" class="form-control-file" type="file" size="20">
                          <span class="help-block"></span>
                      </div>
                  </div>



                  <hr>


                  <!-- KREDIT ==================================> -->
                  <div id="trx_kredit">



                    <div class="form-group row">
                      <label class="control-label col-md-4">DP / Uang Muka</label>
                      <div class="col-md-4">
                        <input name="dp" id="dp" class="form-control" type="text">
                        <span class="help-block"></span>
                      </div>
                    </div>


                    <div class="form-group row">
                      <label class="control-label col-md-4">Lama Cicilan</label>
                      <div class="col-md-4">
                        <select name="lama_cicilan" id="lama_cicilan" class="form-control">
                          <option value="12">12 Bulan</option>
                          <option value="24">24 Bulan</option>
                          <option value="30">30 Bulan</option>
                        </select>
                      </div>
                    </div>



                    <div class="form-group row">
                        <label class="control-label col-md-4">Cicilan Per Bulan</label>
                        <div class="col-md-4">
                            <input name="cicilan_per_bulan" id="cicilan_per_bulan" class="form-control" type="text" readonly>
                            <span class="help-block"></span>
                        </div>
                    </div>



                    <div class="form-group row">
                      <label class="control-label col-md-4">Tanggal Tempo Cicilan Pertama</label>
                      <div class="col-md-4">
                        <input name="tanggal_tempo" placeholder="" class="form-control" type="date">
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="control-label col-md-4">Keterangan</label>
                      <div class="col-md-4">
                        <input name="keterangan" id="keterangan" class="form-control" type="text">
                        <span class="help-block"></span>
                      </div>
                    </div>

                  </div>

                  <!-- BOOKING ==================================> -->
                  <div id="trx_booking">

                    <div class="form-group row">
                      <label class="control-label col-md-4">Pembayaran Booking</label>
                      <div class="col-md-4">
                        <input name="pem_booking" id="pem_booking" class="form-control" type="text" disabled>
                        <input name="pem_booking_int" id="pem_booking_int" class="form-control" type="hidden">
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="control-label col-md-3">Tanggal</label>
                      <div class="col-md-3">
                        <!-- Tambahkan id pada input tanggal untuk mempermudah pengambilan nilai dengan JavaScript -->
                        <input name="tgl_expired" placeholder="" class="form-control" type="date" id="tgl_expired" read-only>
                        <span class="help-block"></span>
                      </div>
                    </div>


                    <div class="form-group row">
                      <label class="control-label col-md-4">Keterangan</label>
                      <div class="col-md-4">
                        <input name="keterangan_booking" id="keterangan_booking" class="form-control" type="text">
                        <span class="help-block"></span>
                      </div>
                    </div>

                  </div>

                  <!-- CASH ==================================> -->
                  <div id="trx_cash">


                    <div class="form-group row">
                      <label class="control-label col-md-4">Pembayaran Cash</label>
                      <div class="col-md-4">
                        <input name="pem_cash" id="pem_cash" class="form-control" type="text">
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="control-label col-md-4">Keterangan</label>
                      <div class="col-md-4">
                        <input name="keterangan" id="keterangan" class="form-control" type="text">
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="control-label col-md-4"></label>
                    <div class="col-md-4">
                      <button class="btn btn-primary btn-md" type="submit" name="submit"> Proses Transaksi</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>


            <div class="col-md-3">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Panjang Kanan <span class="float-right badge bg-info"><?=$kav['panjang_kanan'];?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Panjang Kiri <span class="float-right badge bg-info"><?=$kav['panjang_kiri'];?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Lebar Depan <span class="float-right badge bg-info"><?=$kav['lebar_depan'];?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Lebar Belakang <span class="float-right badge bg-info"><?=$kav['lebar_belakang'];?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Luas Kavling <span class="float-right badge bg-info"><?=$kav['luas_tanah'];?></span>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Harga Jual Tunai <span class="float-right badge bg-info"><?=rupiah($kav['hrg_jual']);?></span>
                  </a>
                </li>

                <div class="form-group row">
            <label class="control-label col-md-4">Informasi Nomor Rekening</label>
            <div class="col-md-8">
                <div class="alert alert-info" role="alert">
                    <p>Nama Bank: <br>Bank Syariah Indonesia (BSI)</p>
                    <p>Atas Nama: KSU BMT 071 Sampit</p>
                    <p>Nomor Rekening: 7023914292</p>
                    <p>Kode Bank: 451</p>
                </div>
            </div>
        </div>

              </ul>
            </div>


          </div>


        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </body>



  </html>





  <?php  $this->load->view('template/footer'); ?>


  <script type="text/javascript">
    $('#harga_jual').on('change', function () {

      var myStr = $(this).val();
      var newStr = myStr.replace(/\D/g, '');
      $('#harga_jual_int').val(newStr);

    });

    $('#dp').on('change', function () {

      var myStr = $(this).val();
      var newStr = myStr.replace(/\D/g, '');
      $('#dp_int').val(newStr);

    });

    $('#cicilan_per_bulan').on('change', function () {

      var myStr = $(this).val();
      var newStr = myStr.replace(/\D/g, '');
      $('#cicilan_per_bulan_int').val(newStr);

    });

    $('#pem_booking').on('change', function () {

      var myStr = $(this).val();
      var newStr = myStr.replace(/\D/g, '');
      $('#pem_booking_int').val(newStr);

    });

    $('#pem_cash').on('change', function () {

      var myStr = $(this).val();
      var newStr = myStr.replace(/\D/g, '');
      $('#pem_cash_int').val(newStr);

    });


    $('#fee_marketing').on('change', function () {

      var myStr = $(this).val();
      var newStr = myStr.replace(/\D/g, '');
      $('#fee_marketing_int').val(newStr);

    });

    $('#fee_notaris').on('change', function () {

      var myStr = $(this).val();
      var newStr = myStr.replace(/\D/g, '');
      $('#fee_notaris_int').val(newStr);

    });


    /* Tanpa Rupiah */
    var harga_jual = document.getElementById('harga_jual');
    harga_jual.addEventListener('keyup', function (e) {
      harga_jual.value = formatRupiah(this.value);
    });

    var dp = document.getElementById('dp');
    dp.addEventListener('keyup', function (e) {
      dp.value = formatRupiah(this.value);
    });

    var cicilan_per_bulan = document.getElementById('cicilan_per_bulan');
    cicilan_per_bulan.addEventListener('keyup', function (e) {
      cicilan_per_bulan.value = formatRupiah(this.value);
    });

    var pem_booking = document.getElementById('pem_booking');
    pem_booking.addEventListener('keyup', function (e) {
      pem_booking.value = formatRupiah(this.value);
    });

    var pem_cash = document.getElementById('pem_cash');
    pem_cash.addEventListener('keyup', function (e) {
      pem_cash.value = formatRupiah(this.value);
    });

    var fee_marketing = document.getElementById('fee_marketing');
    fee_marketing.addEventListener('keyup', function (e) {
      fee_marketing.value = formatRupiah(this.value);
    });

    var fee_notaris = document.getElementById('fee_notaris');
    fee_notaris.addEventListener('keyup', function (e) {
      fee_notaris.value = formatRupiah(this.value);
    });

    harga_jual.addEventListener('keydown', function (event) {
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
  <link rel="stylesheet" type="text/css"
    href="<?php echo base_url('assets/admin/plugins/select2/select2-bootstrap.css') ?>">

  <script type="text/javascript">
    var url_apps = "<?=base_url();?>"

    function myFunction() {
      var jenis = document.getElementById("jenis").value;
      if (jenis == '0') {
        $('#trx_kredit').hide();
        $('#trx_cash').hide();
        $('#trx_booking').hide();
      } else if (jenis == '1') {
        $('#trx_kredit').hide();
        $('#trx_cash').hide();
        $('#trx_booking').show();
      } else if (jenis == '2') {
        $('#trx_kredit').hide();
        $('#trx_cash').show();
        $('#trx_booking').hide();
      } else if (jenis == '3') {
        $('#trx_kredit').show();
        $('#trx_cash').hide();
        $('#trx_booking').hide();
      }
    }

    $(document).ready(function () {

      $('#trx_kredit').hide();
      $('#trx_cash').hide();
      $('#trx_booking').hide();

      //----->
      //Ambil semua data customer untuk select 2
      $("#customer").select2({
        ajax: {
          url: url_apps + 'transaksi/ajax_select_customer',
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



    //Ambil semua data customer untuk select 2
    $("#marketing").select2({
      ajax: {
        url: url_apps + 'transaksi/ajax_select_marketing',
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
                text: item.nama_marketing,
                id: item.id_marketing
              }
            })
          };
        },
        cache: true
      },
      minimumInputLength: 1,
    });


    $(document).ready(function () {
      // Dapatkan tanggal hari ini
      var today = new Date();
      // Tambahkan 7 hari (1 minggu) pada tanggal hari ini
      var nextWeek = new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000);
      var dd = String(nextWeek.getDate()).padStart(2, '0');
      var mm = String(nextWeek.getMonth() + 1).padStart(2, '0'); // January is 0!
      var yyyy = nextWeek.getFullYear();

      nextWeek = yyyy + '-' + mm + '-' + dd;
      // Set nilai default input tanggal
      document.getElementById("tgl_expired").value = nextWeek;
    });

    // Jalankan fungsi saat halaman dimuat
    $(document).ready(function () {
      // Tentukan nilai default untuk pembayaran booking
      var defaultValue = 1500000; // Nilai booking default (misalnya 1.500.000)

      // Set nilai default pada input pembayaran booking dan input hidden
      $('#pem_booking').val(defaultValue); // Set nilai pada input visible
      $('#pem_booking_int').val(defaultValue); // Set nilai pada input hidden
    });

    $('#nama_barang').on('change', function () {
      var idSiswa = $(this).val();
      $.ajax({
          url: url_apps + 'adm_penerimaanbarang/get_barang/' + $(this).val(),
          type: 'GET',
          dataType: 'json',
        })
        .done(function (data) {
          //alert(data.ALAMAT);
          // alert('asd');
          $("#nama_barang_real").val(data.nama_barang);

        })
        .fail(function () {
          console.log("error");
        })
        .always(function () {
          console.log("complete");
        });

    });

    $(document).ready(function() {
    // Set nilai default untuk fee marketing
    var defaultFeeMarketing = 1000000; // Nilai fee marketing default (misalnya 1.000.000)
    $('#fee_marketing').val('');
    $('#fee_marketing').prop('readonly', true);  // Kosongkan nilai fee marketing secara default

    // Otomatis atur nilai fee marketing saat form marketing diisi
    $('#marketing').on('change', function() {
        if ($(this).val() !== '') {
            $('#fee_marketing').val(defaultFeeMarketing); // Set nilai fee marketing ke default jika form marketing diisi
        } else {
            $('#fee_marketing').val(''); // Kosongkan nilai fee marketing jika form marketing tidak diisi
        }
    });
});



    $(document).ready(function() {
    // Set nilai default untuk DP
    var defaultValueDP = 1500000; // Nilai DP default (misalnya 1.500.000)
    $('#dp').val(defaultValueDP); // Set nilai pada input DP
    $('#dp').prop('readonly', true); // Membuat input DP menjadi readonly
  });

  $(document).ready(function() {
        // Hitung cicilan per bulan saat lama cicilan berubah
        $('#lama_cicilan').on('change', function() {
            var hargaKavling = parseInt($('#harga_jual_int').val().replace(/\D/g, ''), 10); // Ambil dan parse harga jual cash
            var dp = parseInt($('#dp').val().replace(/\D/g, ''), 10); // Ambil dan parse DP
            var lamaCicilan = parseInt($(this).val(), 10); // Ambil dan parse lama cicilan

            if (!isNaN(hargaKavling) && !isNaN(dp) && !isNaN(lamaCicilan) && lamaCicilan > 0) {
                var cicilanPerBulan = (hargaKavling - dp) / lamaCicilan; // Hitung cicilan per bulan
                $('#cicilan_per_bulan').val(formatRupiah(cicilanPerBulan.toString())); // Tampilkan hasil yang diformat
            } else {
                $('#cicilan_per_bulan').val(''); // Kosongkan bidang jika ada input yang tidak valid
            }
        });
    });

    // Fungsi formatRupiah untuk menampilkan angka dalam format mata uang
    function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{1,3}/g);
        
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

  </script>