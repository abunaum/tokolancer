<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="mb-5 stretch-full-width">
    <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
    <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
    <div class="col-full">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <div id="mdb-lightbox-ui"></div>
                <div class="mdb-lightbox">
                    <div class="row product-gallery mx-1">
                        <div class="col-12 mb-0">
                            <figure class="view overlay rounded z-depth-1 main-img">
                                <img src="<?= base_url(); ?>/img/produk/<?= $produk->gambar; ?>" class="img-thumbnail z-depth-1">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8" style="background-color: #dce0e0;">
                <center>
                    <h5><?= $produk->nama; ?></h5>
                    <p class="text-muted text-uppercase small"><i>Stok : <?= $produk->stok; ?></i></p>
                    <div>
                        <span class="iconify" data-icon="emojione:star" data-inline="false"></span>
                        <span class="iconify" data-icon="emojione:star" data-inline="false"></span>
                        <span class="iconify" data-icon="emojione:star" data-inline="false"></span>
                        <span class="iconify" data-icon="emojione:star" data-inline="false"></span>
                        <span class="iconify" data-icon="emojione:star" data-inline="false"></span>
                    </div>
                    <p>
                        <span class="mr-1">
                            <strong>Rp. <?= number_format($produk->harga); ?></strong>
                        </span>
                    </p>
                    <p class="pt-1" style="white-space: pre-line">
                        <?= $produk->keterangan; ?>
                    </p>
                    <hr>
                    <form action="<?= base_url('user/toko/produk/hapus') . '/' . $produk->id; ?>" method="post" class="d-inline">
                        <input type="hidden" name="_method" value="DELETE" />
                        <button type="button" class="btn btn-danger tmbl-hps" data-nama="<?= $produk->nama; ?>">Hapus</button>
                    </form>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
                </center>
            </div>
        </div>
        <hr class="mb-2 mt-2" style="border-top: 2px dashed green;">
        <div class="tm-related-products-carousel section-products-carousel">
            <section class="related">
                <header class="section-header">
                    <h2 class="section-title">Produk Toko</h2>
                    <nav class="custom-slick-nav"></nav>
                </header>

                <div class="products">
                    <?php foreach ($produkuser as $pu) : ?>
                        <div class="product">
                            <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?= base_url('/user/toko/produk/detail') . '/' . $pu['id']; ?>">
                                <img style="height: 150px; width: 150px;" class="img-thumbnail" src="<?= base_url(); ?>/img/produk/<?= $pu['gambar']; ?>" alt="Gambar">
                                <span class="price">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">Rp </span><?= number_format($pu['harga']); ?></span>
                                </span>

                                <h2 class="woocommerce-loop-product__title"><?= $pu['nama']; ?></h2>
                                <h2 class="woocommerce-loop-product__title"><i>@<?= $toko->username; ?></i></h2>
                            </a>

                            <div class="hover-area">
                                <a class="button" href="<?= base_url('/user/toko/produk/detail') . '/' . $pu['id']; ?>">Detail</a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>
</section>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Dagangan</h5>
            </div>
            <div class="modal-body">
                <center>
                    <form class="g-3 needs-validation" action="<?= base_url('user/toko/produk/edit') . '/' . $produk->id; ?>" enctype="multipart/form-data" method="post" novalidate>
                        <?= csrf_field(); ?>
                        <div class="mt-2">
                            <img class="ard-img-top rounded-circle col col-md-6 mb-3 lihat-gambar" alt="gambar" src="<?= base_url(); ?>/img/produk/<?= $produk->gambar; ?>">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" placeholder="Nama Produk" aria-label="nama" name="nama" id="nama" aria-describedby="basic-addon1" value="<?= (old('nama')) ? old('nama') : $produk->nama ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"><?= (old('keterangan')) ? old('keterangan') : $produk->keterangan ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('keterangan'); ?>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                            <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : '' ?>" placeholder="Harga" aria-label="harga" name="harga" id="harga" aria-describedby="basic-addon1" value="<?= (old('harga')) ? old('harga') : $produk->harga ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('harga'); ?>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Stok</span>
                            <input type="number" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : '' ?>" placeholder="Stok" aria-label="stok" name="stok" id="stok" aria-describedby="basic-addon1" value="<?= (old('stok')) ? old('stok') : $produk->stok ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('harga'); ?>
                            </div>
                        </div>
                        <label for="gambar">Gambar tidak wajib di ubah</label>
                        <div class="input-group mb-3">
                            <input type="file" id="gambar" name="gambar" class="form-control-file <?= ($validation->hasError('gambar')) ? 'is-invalid' : '' ?>" onchange="profilpreview()">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </center>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    function profilpreview() {
        const gambar = document.querySelector('#gambar');
        const previewimg = document.querySelector('.lihat-gambar');

        const filegambar = new FileReader();
        filegambar.readAsDataURL(gambar.files[0]);

        filegambar.onload = function(e) {
            previewimg.src = e.target.result;
        }
    }
</script>
<?= $this->endSection(); ?>