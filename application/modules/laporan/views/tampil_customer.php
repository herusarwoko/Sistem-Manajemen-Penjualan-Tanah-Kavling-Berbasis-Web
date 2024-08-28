<?php 
$kode_kavling = $this->input->post('kode_kavling');
$idCust = $this->input->post('customer');
//cari kode kavling
$kodeKav = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling='$kode_kavling'")->row_array();
$NamaCust = $this->db->query("SELECT * FROM customer LEFT JOIN kategori ON customer.id_customer = kategori.id_customer 
                                WHERE kategori.id_customer='$idCust'")->row_array();
$idKategori = $NamaCust['kategori_id'];
$query = "";
$no=1;
$total = 0;

    $query = "SELECT * FROM transaksi WHERE transaksi_kategori='$idKategori'";
    $data = $this->db->query($query)->result();

?>
    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Laporan Pembayaran Customer<br>
        Nama Customer : <?=$NamaCust['nama_lengkap'];?><br>
        Lokasi Kavling : <?=$kodeKav['kode_kavling'];?>
    </h3>
              <div class="card-tools">
                <a href="<?=base_url('laporan/cetak_pemasukan');?>" target="_blank" class="btn btn-info btn-sm" ><i class="fa fa-plus"></i> Cetak PDF</a>&nbsp;
                <a href="<?=base_url('laporan/excel');?>" target="_blank"  class="btn btn-warning btn-sm" ><i class="fa fa-plus"></i> Cetak Excel</a>&nbsp;
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
                        <th width="40%">Deskripsi</th>
                        <th width="20%">Jenis / Keterangan</th>
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
                        <td width="40%"><?=$dt->transaksi_keterangan;?></td>
                        <td width="20%"><?=$dt->transaksi_barang;?></td>
                        <td width="20%" align="right"><?=rupiah($dt->transaksi_nominal);?></td>
                    </tr>

                    <?php 
                    $total = $total + $dt->transaksi_nominal;
                    }
                    ?>

                    <tr>
                        <td width="5%" colspan="4"></td>
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