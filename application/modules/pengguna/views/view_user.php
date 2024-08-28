  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pengaturan Pengguna</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Pengguna</li>
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
          <h3 class="card-title">Data Pengguna Aplikasi</h3>
              <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">

         
      <form action="<?=base_url("pengguna/update_user");?>" id="form" class="form-horizontal" method="POST">
          <input type="hidden" value="<?=$pengguna['id'];?>" name="id" id="id"/>

          <?php
          if($alert == '1'){
            echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Data berhasi diupdate</h5>
                </div>';
          }
          ?>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Nama Lengkap </label>
            <div class="col-md-5">
              <input name="surname" type="text" class="form-control" id="surname"  value="<?=$pengguna['surname'];?>">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-md-5">
              <input name="username" type="text" class="form-control" id="username" value="<?=$pengguna['username'];?>">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-md-5">
              <input name="password" type="password" class="form-control" id="password">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label"></label>
            <div class="col-md-5">
              <button class="btn btn-info btn-sm"  type="submit" ><i class="fa fa-plus"></i> Update</button>
            </div>
          </div>
                                                  
          </form>

      </div>



          </table>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>

<?php  $this->load->view('template/footer'); ?>




