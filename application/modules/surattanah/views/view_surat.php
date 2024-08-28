<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tracking Progress Surat Tanah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        /* Custom styles */
        body {
            margin: 10vh 0 0 35vh;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 class="mt-5 mb-4">Tracking Progress Surat Tanah</h3>
        <div class="mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="fa fa-plus"></i> Tambah
            </button>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nomor Surat Tanah</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal Update Terakhir</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($surat_tanah_progress as $progress): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $progress['nomor_surat_tanah']; ?></td>
                    <td><?= $progress['status']; ?></td>
                    <td><?= $progress['tanggal_update']; ?></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editModal<?= $progress['id']; ?>">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus(<?= $progress['id']; ?>)">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Surat Tanah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form tambah data surat tanah -->
                    <form>
                        <div class="mb-3">
                            <label for="nomorSuratTanah" class="form-label">Nomor Surat Tanah</label>
                            <input type="text" class="form-control" id="nomorSuratTanah">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status">
                        </div>
                        <div class="mb-3">
                            <label for="tanggalUpdate" class="form-label">Tanggal Update Terakhir</label>
                            <input type="date" class="form-control" id="tanggalUpdate">
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <?php foreach ($surat_tanah_progress as $progress): ?>
    <div class="modal fade" id="editModal<?= $progress['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Surat Tanah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form edit data surat tanah -->
                    <form>
                        <div class="mb-3">
                            <label for="nomorSuratTanah" class="form-label">Nomor Surat Tanah</label>
                            <input type="text" class="form-control" id="nomorSuratTanah"
                                value="<?= $progress['nomor_surat_tanah']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" value="<?= $progress['status']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="tanggalUpdate" class="form-label">Tanggal Update Terakhir</label>
                            <input type="date" class="form-control" id="tanggalUpdate"
                                value="<?= $progress['tanggal_update']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>

    <script>

    function hapus(id){
        $.confirm({
        title: 'Confirm!',
        content: 'Apakah anda yakin menghapus data ini ?',
        buttons: {
            confirm: function () {
            $.ajax({
                url : url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_delete/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    reload_table();
                    Lobibox.notify('success', {
                        size: 'mini',
                        msg: 'Data berhasil Dihapus'
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
</body>

</html>