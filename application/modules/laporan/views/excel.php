<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=abc.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
$jenis = $this->input->get('jenis');
$awal = $this->input->get('awal');
$akhir = $this->input->get('akhir');
$query = "";
$no=1;
$total = 0;
if($jenis == '1'){
    $query = "SELECT * FROM pembayaran WHERE tanggal >= '$awal' AND tanggal <= '$akhir'";
    $data = $this->db->query($query)->result();

?>
<table border="1">
    <thead>
        <tr>
            <td colspan="5" align="center">LAPORAN PENERIMAAN</td>
        </tr>
        <tr>
            <td colspan="5" align="center">Periode : <?=tgl_indo($awal).' - '.tgl_indo($akhir);?></td>
        </tr>
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
            <td width="15%"><?=tgl_indo($dt->tanggal);?></td>
            <td width="40%"><?=$dt->deskripsi;?></td>
            <td width="20%"><?=$dt->keterangan;?></td>
            <td width="20%" align="right"><?=rupiah($dt->jumlah_bayar);?></td>
        </tr>

        <?php 
        $total = $total + $dt->jumlah_bayar;
        }
        ?>

        <tr>
            <td width="5%" colspan="4"></td>
            <td width="20%" align="right"><?=rupiah($total);?></td>
        </tr>
    </tbody>
</table>

       
<?php
}else{
    $query = "SELECT * FROM pengeluaran WHERE tanggal >= '$awal' AND tanggal <= '$akhir'";
    $data = $this->db->query($query)->result();
?>


<table border="1">
    <thead>
        <tr>
            <td colspan="5" align="center">LAPORAN PENERIMAAN</td>
        </tr>
        <tr>
            <td colspan="5" align="center">Periode : <?=tgl_indo($awal).' - '.tgl_indo($akhir);?></td>
        </tr>
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
            <td width="15%"><?=tgl_indo($dt->tanggal);?></td>
            <td width="40%"><?=$dt->deskripsi;?></td>
            <td width="20%"><?=$dt->keterangan;?></td>
            <td width="20%" align="right"><?=rupiah($dt->sub_total);?></td>
        </tr>

        <?php 
        $total = $total + $dt->sub_total;
        }
        ?>

        <tr>
            <td width="5%" colspan="4"></td>
            <td width="20%" align="right"><?=rupiah($total);?></td>
        </tr>
    </tbody>
</table>

<?php
}
?>
