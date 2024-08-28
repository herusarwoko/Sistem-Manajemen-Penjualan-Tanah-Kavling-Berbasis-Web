<?php 
$kategori = $this->input->post('kategori');
$awal = $this->input->post('awal');
$akhir = $this->input->post('akhir');
$query = "";
$no=1;
$total = 0;

    $query = "SELECT * FROM transaksi t 
    LEFT JOIN kategori k ON t.transaksi_kategori = k.kategori_id 
    WHERE t.transaksi_tanggal >= '$awal' AND t.transaksi_tanggal <= '$akhir' AND k.kategori_id='$kategori'"; 
    $data = $this->db->query($query)->result();

?>
    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Laporan Berdasarkan Kategori</h3>
              <div class="card-tools">
                <a href="<?=base_url('laporan/cetak_pemasukan?awal='.$awal.'&akhir='.$akhir.'&jenis='.$kategori);?>" target="_blank" class="btn btn-info btn-sm" ><i class="fa fa-plus"></i> Cetak PDF</a>&nbsp;
                <a href="<?=base_url('laporan/excel?jenis=1&awal='.$awal.'&akhir='.$akhir);?>" target="_blank"  class="btn btn-warning btn-sm" ><i class="fa fa-plus"></i> Cetak Excel</a>&nbsp;
              </div>
              <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%">Kategori / Customer</th>
                        <th width="20%">Keterangan</th>
                        <th width="20%">Jenis Transaksi</th>
                        <th width="20%">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    foreach($data as $dt){
                    ?>
                <tr>
                        <td width="5%"><?=$no++;?></td>
                        <td width="15%"><?=tgl_indo($dt->transaksi_tanggal);?></td>
                        <td width="20%"><?=$dt->kategori;?></td>
                        <td width="40%"><?=$dt->transaksi_keterangan;?></td>
                        <td width="40%"><?=$dt->transaksi_jenis;?></td>
                        <td width="20%" align="right"><?=rupiah($dt->transaksi_nominal);?></td>
                    </tr>

                    <?php 
                    $total = $total + $dt->transaksi_nominal;
                    }
                    ?>

                    <tr>
                        <td width="5%" colspan="5"></td>
                        <td width="20%" align="right"><?=rupiah($total);?></td>
                    </tr>
                </tbody>
            </table>

          </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>


</body>
</html>