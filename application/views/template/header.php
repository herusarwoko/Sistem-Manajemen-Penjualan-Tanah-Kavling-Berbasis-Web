<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIM-KAVLING</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/'); ?>plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/'); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/'); ?>plugins/toastr/toastr.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/'); ?>dist/css/adminlte.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

      
        <link href="<?=base_url('theme/plugins/datatables/jquery.dataTables.min.css');?>" rel="stylesheet">
        <link href="<?=base_url('theme/dist/css/Lobibox.min.css');?>" rel="stylesheet" />
        <link href="<?=base_url('theme/dist/css/jquery-confirm.min.css'); ?>" rel="stylesheet">





</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<?php 
$menuAktif = $this->uri->segment(1);
?>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-blue navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="<?=base_url();?>">
                    SIM-KAVLING
                    </a>

                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <?php 
            $konf = $this->db->get_where('konfigurasi', array('id'=>'1'))->row_array();
            ?>
            <a href="<?= base_url(); ?>" class="brand-link">
                <img src="<?=base_url('assets/aplikasi/'.$konf['logo']);?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><strong>SIM-KAVLING</strong></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <?php
                    $id = $this->encryption->decrypt($this->session->userdata('id'));
                    $hakAkses = $this->db->query("SELECT * FROM hak_akses h 
                    LEFT JOIN users u ON h.id_user = u.id 
                    LEFT JOIN menu m ON h.id_menu = m.id_menu 
                    WHERE u.id = '$id' AND h.status_hak = '1' AND m.id_parent='0' ORDER BY urutan ASC")->result(); 

                    foreach($hakAkses as $hak){

                        //cek apakah punya sub menu
                        $submenu = $this->db->query("SELECT * FROM menu WHERE id_parent='$hak->id_menu'")->num_rows();
                        if($submenu > 0){ 
                            $hakAksesSub = $this->db->query("SELECT * FROM hak_akses h 
                            LEFT JOIN users u ON h.id_user = u.id 
                            LEFT JOIN menu m ON h.id_menu = m.id_menu 
                            WHERE u.id = '$id' AND h.status_hak = '1' AND m.id_parent='$hak->id_menu' ORDER BY urutan ASC")->result(); 

                           
                            $cek = $this->db->query("SELECT * FROM menu WHERE id_parent='$hak->id_menu' AND url='$menuAktif'")->num_rows();
                            if($cek > 0){
                                $openMenu = 'menu-open';
                                $aktifInduk = 'active';
                            }else{
                                $openMenu = '';
                                $aktifInduk = '';
                            }
                    ?>

                        <li class="nav-item <?=$openMenu;?>">
                            <a href="#" class="nav-link <?=$aktifInduk;?>">
                            <i class="nav-icon fas <?=$hak->icon;?>"></i>
                            <p>
                                <?=$hak->title_menu;?>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">

                            <?php 
                            foreach($hakAksesSub as $hakSub){ 
                                 // cek menu aktif ----------------------->
                            if ($this->uri->segment(1) == $hakSub->url){
                                $aktif = 'active';
                            }else{
                                $aktif = '';
                            }
                            ?>
                            <li class="nav-item">
                                <a href="<?= base_url($hakSub->url); ?>" class="nav-link  <?=$aktif;?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?=$hakSub->title_menu;?></p>
                                </a>
                            </li>
                            <?php } ?>
                            </ul>
                        </li>

                        <?php }else{
                            // cek menu aktif --------------------
                            if ($this->uri->segment(1) == $hak->url){
                                $aktif = 'active';
                            }else{
                                $aktif = '';
                            }
                    ?>

                    
                        <li class="nav-item">
                            <a href="<?= base_url($hak->url); ?>" class="nav-link <?=$aktif;?>">
                                <i class="nav-icon fas <?=$hak->icon;?>"></i>
                                <p>
                                    <?=$hak->title_menu;?>
                                </p>
                            </a>
                        </li>

                        <?php }
                    } ?>


                        <li class="nav-item">
                            <a href="<?= base_url('login/logout'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Keluar
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>