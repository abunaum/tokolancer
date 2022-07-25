
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Naum Market">
    <meta name="author" content="Abunaum">

    <!-- Title Page-->
    <title><?= $judul; ?></title>

    <!-- Fontfaces CSS-->
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/css/font-face.css" rel="stylesheet" media="all">
    <script src="https://kit.fontawesome.com/1ef64ee6ba.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/css/theme.css" rel="stylesheet" media="all">
    <link rel="shortcut icon" href="<?= base_url('tokolancer.ico'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/swal2/sweetalert2.min.css">
    <?= $this->renderSection('head'); ?>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="<?= base_url('admin'); ?>">
                            <img src="<?= base_url(); ?>/logotoko.png" alt="Abunaum" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <?= $this->include('mypanel/navbar') ?>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <?= $this->include('mypanel/sidebar') ?>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?= $this->include('mypanel/headerdekstop') ?>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <?= $this->renderSection('content'); ?>
            <!-- END MAIN CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <p>Copyright © <?= date('Y') ?> <?= $_SERVER['HTTP_HOST'] ?>. All rights reserved. Template by <a href="https://facebook.com/ahmad.yani.ardath">Abunaum</a>.</p>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/slick/slick.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/wow/wow.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/animsition/animsition.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/mypanel/js/main.js"></script>
    <!-- Extra JS Gua-->
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/swal2/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/swal2/swall.js"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <?= $this->renderSection('script'); ?>

</body>

</html>
<!-- end document-->