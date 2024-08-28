<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pesona Mentaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnec t" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&display=swap"
        rel="stylesheet">
</head>

<body>
    <!-- navbar -->
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <a class="navbar-brand me-auto" href="#">
                            <img src="assets/img/logo.png" class="logo-header img-fluid" alt="">
                        </a>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                            aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Pesona Mentaya</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                                    <li class="nav-item">
                                        <a class="nav-link nav-home mx-lg-2" aria-current="page" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-lg-2" href="#">Produk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-lg-2" href="#">Kontak</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-lg-2" href="#tentang-kami">Tentang Kami</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <a href="" class="login-button btn btn-primary">Login</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- end navbar -->

    <!-- header judul -->
    <div class="container-fluid" id="home">
        <div class="row row-cols-1 row-cols-sm-2 header-text ">
            <div class="col">
                <h1 class="judul-heading">Pesona Mentaya, <br>
                    Pusat Penjualan Tanah Kavling (Properti) Murah Dan Aman Di Kota Sampit
                </h1>
                <p class="judul-subheading">Pesona Mentaya bukan hanya tentang tanah, tetapi juga tentang investasi masa
                    depan. Dengan nilai yang
                    terus meningkat, kavling tanah di sini adalah peluang investasi yang cerdas dan menjanjikan. <br>
                    Saatnya Untuk Mewujudkan Impian Memiliki Lahan Kavling, Murah & Aman dengan Lokasi Strategis di Kota
                    Sampit.</p>
                <div class="row">
                    <div class="col">
                        <a href="#" class="btn btn-primary btn-more-header">Lebih Lanjut</a>
                    </div>
                    <div class="col">
                        <img src="assets/img/play.png" class="img-fluid logo-play" alt="" srcset="">
                    </div>
                </div>
            </div>
            <div class="col text-center">
                <img src="assets/img/img-header.png" class="img-fluid img-header" alt="" srcset="">
            </div>
        </div>
    </div>
    <!-- end header judul -->

    <!-- pencarian property -->
    <div class="row row-pencarian-property justify-content-center">
        <form class="row form-pencarian-property g-4 align-middle justify-content-center">
            <div class="col-auto">
                <select class="form-select" aria-label="Default select example">

                    <option selected>-Pilih Lokasi-</option>
                    <option value="1">Sampit</option>
                    <option value="2">PangkalanBun</option>
                    <option value="3">Samuda</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="staticEmail2" class="visually-hidden">Email</label>
                <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="email@example.com">
            </div>
            <div class="col-auto">
                <label for="inputPassword2" class="visually-hidden">Password</label>
                <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3 btn-search-property">Search</button>
            </div>
        </form>
    </div>
    <!-- end pencarian property -->

    <!-- tentang kami -->
    <div class="container-fluid container-tentang-kami" id="tentang-kami">
        <div class="row row-tentang-kami row-cols-1 row-cols-sm-2">
            <div class="col">
                <img src="assets/img/img-tentang-kami.png" class="img-fluid" alt="" srcset="">
            </div>
            <div class="col text-tentang-kami">
                <h3>Tentang Kami</h3>
                <h1>Selamat datang di Pesona Mentaya, Tempat Terbaik untuk Mewujudkan Impian Anda!</h1>
                <p>Kami adalah perusahaan yang berkomitmen untuk memberikan pengalaman investasi tanah yang tak
                    terlupakan. Dengan koleksi kavling eksklusif kami, Anda akan menemukan potensi luar biasa untuk
                    memiliki properti dengan nilai yang terus berkembang. Keindahan alam dan aksesibilitas yang optimal
                    menjadi nilai tambah yang membuat tanah kavling kami begitu istimewa. Bergabunglah dengan kami di
                    perjalanan menuju masa depan yang lebih baik, melalui investasi tanah kavling di Pesona Mentaya.
                </p>
            </div>
        </div>
    </div>
    <!-- end tentang kami -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
        </script>
</body>

</html>