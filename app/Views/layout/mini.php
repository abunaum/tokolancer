<div class="col-full handheld-only">
    <div class="handheld-header">
        <div class="row">
            <div class="site-branding">
                <a href="<?= base_url(); ?>">
                    <img src="<?= base_url(); ?>/logotoko.png" alt="Toko Lancer">
                </a>
                <!-- /.custom-logo-link -->
            </div>
            <!-- /.site-branding -->
            <!-- ============================================================= End Header Logo ============================================================= -->
            <?php helper('auth'); ?>
            <?php if (cek_login() == true) : ?>
                <div class="handheld-header-links">
                    <ul class="nav-item">
                        <li class="my-account">
                            <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <img src="<?= user()->user_image; ?>" width="24" height="24" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('user/notifikasi'); ?>">
                                    Notifikasi
                                </a>
                                <hr>
                                <a class="dropdown-item" href="<?= base_url('user/order/keranjang'); ?>">
                                    <?php
                                    $keranjang = new \App\Models\Keranjang();
                                    $keranjang->where('buyer', user()->id);
                                    $keranjang->where('status', 1);
                                    $totalkeranjang = $keranjang->countAllResults();
                                    ?>
                                    <?php if ($totalkeranjang >= 1) : ?>
                                        Keranjang ( <?= $totalkeranjang ?> )
                                    <?php else : ?>
                                        Keranjang
                                    <?php endif; ?>
                                </a>
                                <hr>
                                <a class="dropdown-item" href="<?= base_url('user/order/transaksi'); ?>">
                                    Invoice
                                </a>
                                <hr>
                                <a class="dropdown-item" href="<?= base_url('toko'); ?>">
                                    Toko
                                </a>
                                <hr>
                                <a class="dropdown-item">
                                    Saldo Rp. <?= number_format(user()->balance) ?>
                                </a>
                                <hr>
                                <a class="dropdown-item" href="<?= base_url('logout'); ?>">
                                    Logout
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="cart-contents" href="<?= base_url('user/notifikasi'); ?>">
                                <span class="iconify" data-icon="ic:outline-notifications-active" data-inline="false"
                                      data-width="24" data-height="24"></span>
                            </a>
                        </li>
                    </ul>
                    <!-- .columns-3 -->
                </div>
            <?php else : ?>
                <div class="handheld-header-links">
                    <ul class="columns-2">
                        <li class="my-account">
                            <a href="<?= base_url('login'); ?>" class="has-icon">
                                <span class="iconify" data-icon="ant-design:login-outlined" data-inline="false"
                                      data-width="24" data-height="24"></span>
                            </a>
                        </li>
                    </ul>
                    <!-- .columns-2 -->
                </div>
            <?php endif; ?>
            <!-- .handheld-header-links -->
        </div>
        <!-- /.row -->
        <div class="techmarket-sticky-wrap">
            <div class="row">
                <nav id="handheld-navigation" class="handheld-navigation" aria-label="Handheld Navigation">
                    <button class="btn navbar-toggler" type="button">
                        <span class="iconify" data-icon="ep:menu" data-width="32" data-height="32"></span>
                    </button>
                    <div class="handheld-navigation-menu">
                        <a href="<?= base_url(); ?>">
                            <div class="yamm-content">
                                <div class="bg-yamm-content bg-yamm-content-bottom bg-yamm-content-right">
                                    <div class="kc-col-container">
                                        <div class="kc_single_image">
                                            <img src="<?= base_url(); ?>/logotoko.png" alt=""/>
                                        </div>
                                        <!-- .kc_single_image -->
                                    </div>
                                    <hr>
                                    <!-- .kc-col-container -->
                                </div>
                            </div>
                        </a>
                        <?php foreach ($item as $i) : ?>
                            <ul id="menu-departments-menu-1" class="nav row">
                                <li class="menu-item menu-item-has-children animate-dropdown dropdown-submenu">
                                    <a title="Toko" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true"
                                       href="#"><?= $i['namaitem']; ?><span
                                                class="caret"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu">
                                        <li class="menu-item menu-item-object-static_block animate-dropdown">
                                            <div class="yamm-content">
                                                <ul>
                                                    <?php $nama = $i['namaitem']; ?>
                                                    <?php foreach ($i[$nama] as $s) : ?>
                                                        <li>
                                                            <a href="<?= base_url('jenis') . '/' . $s['id']; ?>">
                                                                <?= $s['nama']; ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <!-- .kc_row -->
                                            </div>
                                            <!-- .yamm-content -->
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        <?php endforeach; ?>
                        <hr>
                    </div>
                    <!-- .handheld-navigation-menu -->
                </nav>
                <!-- .handheld-navigation -->
                <div class="site-search">
                    <div class="widget woocommerce widget_product_search">
                        <form role="search" method="post" class="woocommerce-product-search"
                              action="<?= base_url(); ?>">
                            <label class="screen-reader-text" for="woocommerce-product-search-field-0">Cari:</label>
                            <input type="search" id="woocommerce-product-search-field-0" class="search-field"
                                   placeholder="Cari &hellip;" value="" name="search"/>
                            <input type="submit" value="Search"/>
                            <input type="hidden" name="post_type" value="product"/>
                        </form>
                    </div>
                    <!-- .widget -->
                </div>
                <!-- .site-search -->
                <?php if (cek_login() == true) : ?>
                    <a class="handheld-header-cart-link has-icon" href="#">
                        <span class="iconify" data-icon="ic:outline-local-grocery-store" data-inline="false"
                              data-width="24" data-height="24"></span>
                        <?php
                        $keranjang = new \App\Models\Keranjang();
                        $keranjang->where('buyer', user()->id);
                        $keranjang->where('status', 1);
                        $totalkeranjang = $keranjang->countAllResults();
                        ?>
                        <?php if ($totalkeranjang >= 1) : ?>
                            <span class="count"><?= $totalkeranjang ?></span>
                        <?php endif; ?>
                    </a>
                    <!--                    </a>-->
                <?php endif; ?>
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- .handheld-header -->
</div>