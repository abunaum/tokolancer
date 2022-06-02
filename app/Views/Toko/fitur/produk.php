<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <div class="categories-filter-products">
            <div class="woocommerce columns-10">
                <div class="products d-flex justify-content-center">
                    <?php foreach ($produk as $p) : ?>
                        <div class="product">
                            <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?= base_url('user/toko/produk/detail') . '/' . $p['id'] ?>">
                                <img style="height: 150px; width: 150px;" class="img-thumbnail" src="<?= base_url(); ?>/img/produk/<?= $p['gambar']; ?>" alt="Gambar">
                                <span class="price">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">Rp </span><?= number_format($p['harga']); ?></span>
                                </span>
                                <h2 class="woocommerce-loop-product__title"><?= $p['nama']; ?></h2>
                            </a>
                            <div class="hover-area d-flex justify-content-center">
                                <form action="<?= base_url('user/toko/produk/hapus') . '/' . $p['id'] ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="button" class="button tmbl-hps">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?= $pager->links(); ?>
    </div>
</section>
<?= $this->endSection(); ?>