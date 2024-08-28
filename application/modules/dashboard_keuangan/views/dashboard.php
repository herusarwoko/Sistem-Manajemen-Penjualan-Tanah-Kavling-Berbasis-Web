<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0 text-dark">Dashboard
          <?php echo $this->encryption->decrypt($this->session->userdata('id')); ?>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

      <div class="row">
        <div class="col-lg-12 col-12">
        

<!-- ================================================================================================== -->
<?php 
$tglSekarang = date('d');
$BlnSekarang = date('m');
$ThnSekarang = date('Y');

$kavling = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta")->row_array();
$book = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE status='1'")->row_array();
$cash = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE status='2'")->row_array();
$kredit = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE status='3'")->row_array();
$ready = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE status='0'")->row_array();

$kav = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE status ='3'")->row_array();
$kreditSelesai = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_cicilan ='1'")->row_array();
$kreditProses = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE stt_cicilan ='0' AND status='3'")->row_array();
$sudahBayarBulanini = $this->db->query("SELECT COUNT(*) as jum FROM pembayaran WHERE jenis_pembelian ='3' AND pembayaran_ke != '0' AND (MONTH(tanggal) = '$BlnSekarang' AND YEAR(tanggal) = '$ThnSekarang')")->row_array();

$belumJT = $this->db->query("SELECT COUNT(*) as jum FROM kavling_peta WHERE tgl_jatuh_tempo < '$tglSekarang'")->row_array();

$sudahBayar = hitungCicilan('10');
$belumBayar = hitungCicilan('11');
$telat_1 = hitungCicilan('1');
$telat_2 = hitungCicilan('2');
$telat_3 = hitungCicilan('3');
$telat_4 = hitungCicilan('4');

@$prosenSudahBayar = (@$sudahBayar / @$kreditProses['jum']) * 100;
// $belumBayar = $kreditProses['jum'] - $sudahBayarBulanini['jum'];
@$prosenBelumBayar = ($belumBayar / $kreditProses['jum']) * 100;
@$prosenTelat_1 = ($telat_1 / $kreditProses['jum']) * 100;
@$prosenTelat_2 = ($telat_2 / $kreditProses['jum']) * 100;
@$prosenTelat_3 = ($telat_3 / $kreditProses['jum']) * 100;
@$prosenTelat_4 = ($telat_4 / $kreditProses['jum']) * 100;

//belum bayar belum jatug tempo
$sudahBayarBelumTempo = $this->db->query("SELECT COUNT(*) as jum FROM pembayaran WHERE jenis_pembelian ='3' AND pembayaran_ke != '0' AND MONTH(tanggal) = '$BlnSekarang'")->row_array();
?>

<!-- Small boxes (Stat box) -->

<div class="row">
        <div class="col-md-6">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget widget-user-2 shadow-sm">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" src="<?=base_url('assets/logo.jpg');?>" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">Statistik Penjualan Kredit</h3>
                <h5 class="widget-user-desc">Per <?=tgl_indo(date('Y-m-d'));?></h5>
              </div>
              
              <div class="card-footer p-0">
              <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col" width="5%">#</th>
      <th scope="col" width="45%">Deskripsi</th>
      <th scope="col" width="15%">Jumlah</th>
      <th scope="col" width="15%">Prosentase</th>
      <th scope="col" width="20%">Action</th>
    </tr>
  </thead>
  <tbody>

  <tr>
      <td scope="row">1</td>
      <td>Kavling Terjual Kredit</td>
      <td align="right"><?=$kav['jum'];?></td>
      <td></td>
      <td align="center"><a href="<?=base_url('transaksi_kredit/detail');?>" class="btn btn-info btn-xs" > Detail Pembayaran</a></td>
    </tr>

    
    <tr>
      <td scope="row">4</td>
      <td>Sudah Membayar Cicilan</td>
      <td align="right"><?=hitungCicilan('10');?></td>
      <td align="right"><?=round($prosenSudahBayar, 1);?> %</td>
      <td align="center"><button onclick="lihatdetail('10')" class="btn btn-xs btn-warning">Detail Data</button></td>
    </tr>


    <tr>
      <td scope="row">5</td>
      <td>Belum Membayar Cicilan</td>
      <td align="right"><?=hitungCicilan('11');?></td>
      <td align="right"><?=round($prosenBelumBayar, 1);?> %</td>
      <td align="center"><button onclick="lihatdetail('11')" class="btn btn-xs btn-warning">Detail Data</button></td>
    </tr>

    <!-- <tr>
      <td scope="row">6</td>
      <td>Belum Membayar (Belum Jatuh Tempo)</td>
      <td align="right"><?=$belumJT['jum'];?></td>
      <td></td>
      <td align="center"><a onclick="proses()" class="btn btn-xs btn-warning">Detail</a></td>
    </tr> -->

    <tr>
      <td scope="row">6</td>
      <td>Belum Membayar Jatuh Tempo 1x</td>
      <td align="right"><?=hitungCicilan('1');?></td>
      <td align="right"><?=round($prosenTelat_1, 1);?> %</td>
      <td align="center"><button onclick="lihatdetail('1')" class="btn btn-xs btn-warning">Detail Data</button></td>
    </tr>

    <tr>
      <td scope="row">6</td>
      <td>Belum Membayar Jatuh Tempo 2x</td>
      <td align="right"><?=hitungCicilan('2');?></td>
      <td align="right"><?=round($prosenTelat_2, 1);?> %</td>
      <td align="center"><button onclick="lihatdetail('2')" class="btn btn-xs btn-warning">Detail Data</button></td>
    </tr>

    <tr>
      <td scope="row">6</td>
      <td>Belum Membayar Jatuh Tempo 3x</td>
      <td align="right"><?=hitungCicilan('3');?></td>
      <td align="right"><?=round($prosenTelat_3, 1);?> %</td>
      <td align="center"><button onclick="lihatdetail('3')" class="btn btn-xs btn-warning">Detail Data</button></td>
    </tr>

    <tr>
      <td scope="row">6</td>
      <td>Belum Membayar Jatuh Tempo > 3x</td>
      <td align="right"><?=hitungCicilan('4');?></td>
      <td align="right"><?=round($prosenTelat_4, 1);?> %</td>
      <td align="center"><button onclick="lihatdetail('4')" class="btn btn-xs btn-warning">Detail Data</button></td>
    </tr>
    
    
  </tbody>
</table>
   
              </div>
              
            </div>
            <!-- /.widget-user -->
          </div>




          
          <div class="col-md-6">
            <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?=$kavling['jum'];?> / <?=$ready['jum'];?></h3>

                <p>Total Kavling / Ready</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$cash['jum'];?></h3>

                <p>Terjual Cash</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Detail Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?=$book['jum'];?></h3>

                <p>Booking</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$kredit['jum'];?></h3>

                <p>Terjual Kredit</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=$kreditProses['jum'];?></h3>

                <p>Proses Cicilan</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><?=$kreditSelesai['jum'];?></h3>

                <p>Selesai Cicilan</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

          </div>
          
          <!-- /.col -->
        </div>
        
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->




<?php  $this->load->view('template/footer'); ?>


<script type="text/javascript">

function lihatdetail(id)
   {
       $('#modal_form').modal('show'); // show bootstrap modal
       $('.modal-title').text('Tambah Konten'); // Set Title to Bootstrap modal title
       $("#detail").load('<?php echo base_url('dashboard_keuangan/detail/');?>'+ id);
   }
</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <div id="detail"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->