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
                            <div class="mt-3 flex-row justify-content-center">
                                <a class="button" href="<?= base_url('user/toko/produk/detail') . '/' . $p['id'] ?>">Detail</a>
                                <form action="<?= base_url('user/toko/produk/hapus') . '/' . $p['id'] ?>" method="post" id="hapus-<?= $p['id'] ;?>">
                                    <?php $id = $p['id'] ;?>
                                    <?php $data = $p['nama'] ;?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <a class="button" onclick="hapus('<?= $id;?>','<?= $data;?>')">
                                        Hapus
                                    </a>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?= $pager->links('produk','halaman'); ?>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    function hapus(id,data){
        formnya = document.getElementById('hapus-'+id);
        nama = data;
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Mau menghapus produk ' + nama + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                formnya.submit();
            }
        })
    }
</script>

<?= $this->endSection(); ?>
