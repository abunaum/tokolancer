<!DOCTYPE html>
<html lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Tempat jual beli item virtual muran dan aman">
    <meta name="theme-color" content="#36f763" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/bootstrap-grid.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/bootstrap-reboot.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/slick.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/slick-style.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/style.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/colors/blue.css" media="all" />
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/gua.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,900" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="/tokolancer.ico"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/swal2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/tombol-buka-tutup.css">
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('img/logo/196.png') ?>">
    <title><?= $judul; ?></title>
</head>

<body class="woocommerce-active page-template-template-homepage-v12">
    <div id="page" class="hfeed site">
        <header id="masthead" class="site-header header-v10" style="background-image: none; ">
            <?= $this->include('layout/max') ?>
            <?= $this->include('layout/mini') ?>
        </header>
        <div id="content" class="site-content">
            <?= $this->renderSection('content'); ?>
            <div class="modal fade" id="namaModal" tabindex="-1" aria-labelledby="namaModalLabel" aria-hidden="true" style="z-index: 99999999999;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <center>
                                <div class="card w-75">
                                    <div class="card-body">
                                        <h5 class="card-title">Ooops !</h5>
                                        <p class="card-text">Akun anda belum mempunyai nama</p>
                                        <hr>
                                        <p>Demi kenyamanan transaksi silahkan ubah nama anda dulu di pengaturan profile.</p>
                                        <a href="<?= base_url('/user/profile') ?>">
                                            <button class="btn btn-success">Ubah Nama</button>
                                        </a>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->include('layout/footer') ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/tether.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/jquery-migrate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/hidemaxlistitem.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/hidemaxlistitem.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/jquery.easing.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/scrollup.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/jquery.waypoints.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/waypoints-sticky.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/pace.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/scripts.js"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/swal2/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/swal2/swall.js"></script>
    <?= $this->renderSection('script'); ?>
    <script src="<?= base_url('upup.min.js') ?>"></script>
    <script>
        UpUp.start({
            'cache-version': 'v2',
            'content-url': '<?= current_url() ?>',
            'content': 'Gagal terhubung ke website, silahkan cek koneksi internet.',
            'service-worker-url': '<?= base_url('upup.sw.min.js') ?>'
        });
    </script>
</body>

</html>