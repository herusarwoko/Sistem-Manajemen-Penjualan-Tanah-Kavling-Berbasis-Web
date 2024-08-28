<?php 
$jenis = $this->input->post('jenis');
$awal = $this->input->post('awal');
$akhir = $this->input->post('akhir');
?>
<div class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Transaksi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">transaksi</li>
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
          <h3 class="card-title">Transaksi Pemasukan & Pengeluaran Periode : <?=tgl_indo($awal);?> - <?=tgl_indo($akhir);?></h3>
              <div class="card-tools">
              <a href="<?=base_url('laporan/cetak_pemasukan?awal='.$awal.'&akhir='.$akhir.'&jenis='.$jenis);?>" target="_blank" class="btn btn-info btn-sm" ><i class="fa fa-plus"></i> Cetak PDF</a>&nbsp;
              
              </div>
              <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
           <thead>
                  <tr>
                    <th width="1%" rowspan="2">NO</th>
                    <th width="10%" rowspan="2" class="text-center">TANGGAL</th>
                    <th width="40%" rowspan="2" class="text-center">KATEGORI</th>
                    <th width="10%" rowspan="2" class="text-center">KETERANGAN</th>
                    <th width="10%" colspan="2" class="text-center">JENIS</th>
                  </tr>
                  <tr>
                    <th width="15%"  class="text-center">PEMASUKAN</th>
                    <th width="15%"  class="text-center">PENGELUARAN</th>
                  </tr>
                </thead>

                <?php 
                $no = 1;
                $transaksi = $this->db->query("SELECT * FROM transaksi 
                LEFT JOIN kategori ON transaksi.transaksi_kategori = kategori.kategori_id 
                LEFT JOIN barang ON transaksi.transaksi_barang = barang.barang_id 
                WHERE transaksi.transaksi_tanggal >= '$awal' AND transaksi.transaksi_tanggal <= '$akhir' ORDER BY transaksi.transaksi_tanggal ASC")->result();
                ?>
                <tbody>
                    <?php 
                    $masuk = 0;
                    $keluar = 0;
                    $pemasukan = 0;
                    $pengeluaran = 0;
                    foreach($transaksi as $trx){
                    echo '<tr>
                        <td>'.$no++.'</td>
                        <td>'.tgl_INDO($trx->transaksi_tanggal).'</td>
                        <td>'.$trx->kategori.' # '.$trx->transaksi_keterangan.'</td>';
                        echo '<td align="center">-</td>';
                        if($trx->transaksi_jenis == 'Pemasukan'){
                            echo '<td align="right">'.rupiah($trx->transaksi_nominal).'</td>';
                            $masuk = $trx->transaksi_nominal;
                            echo '<td align="right">-</td>';
                        }else if($trx->transaksi_jenis == 'Pengeluaran'){
                            echo '<td align="right">-</td>';
                            echo '<td align="right">'.rupiah($trx->transaksi_nominal).'</td>';
                            $keluar = $trx->transaksi_nominal;
                        }
                    echo '</tr>';
                    
                    $pemasukan = $pemasukan + $masuk;
                    $pengeluaran = $pengeluaran + $keluar;
                    // echo ' - ';
                    
                    $masuk = 0;
                    $keluar = 0;
                    
                    } ?>
                    <tr>
                        <td colspan="4" align="right"><b>Total</b></td>
                        <td align="right"><b><?=rupiah($pemasukan);?></b></td>
                        <td align="right"><b><?=rupiah($pengeluaran);?></b></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right"><b>Saldo</b></td>
                        <td colspan="2" align="right"><b><?=rupiah($saldo = $pemasukan - $pengeluaran);?></b></td>
                    </tr>
                </tbody>
            </table>

          </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>


<!-- End Bootstrap modal -->
</body>
</html>
