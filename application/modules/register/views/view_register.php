<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->   
    <link rel="icon" type="image/png" href="<?= base_url('assets/login/'); ?>images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/'); ?>vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/'); ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/'); ?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/'); ?>vendor/animate/animate.css">
<!--===============================================================================================-->   
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/'); ?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/'); ?>vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/'); ?>css/util.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/'); ?>css/main.css">
<!--===============================================================================================-->
</head>
<body>
    
    <div class="limiter">
        <div class="container-login100" style="background-image: url('<?= base_url('assets/login/images/img-01.jpg'); ?>');">
            <div class="wrap-login100 p-t-190 p-b-30">
                <form class="login100-form validate-form" action="<?= base_url('register/process_register'); ?>" method="POST">
                <div class="login100-form-avatar">
                        <img src="<?=base_url('assets/aplikasi/'.$konf['logo']);?>" alt="AVATAR">
                    </div>

                    <span class="login100-form-title p-t-20 p-b-45">
                        Register
                    </span>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Full Name is required">
                        <input class="input100" type="text" name="surname" placeholder="Full Name" autocomplete="off">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Username is required">
                        <input class="input100" type="text" name="username" placeholder="Username" autocomplete="off">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password" autocomplete="off">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Email is required">
                        <input class="input100" type="email" name="email" placeholder="Email" autocomplete="off">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn p-t-10">
                        <button class="login100-form-btn">
                            Register
                        </button>
                    </div>
                </form>

                <!-- link login -->
                <div class="text-center w-full p-t-25 p-b-230">
                    <span class="txt1">
                        Sudah punya akun?
                    </span>

                    <a class="txt1 bo1 hov1" href="<?= base_url('login'); ?>">
                        Login Sekarang              
                    </a>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
