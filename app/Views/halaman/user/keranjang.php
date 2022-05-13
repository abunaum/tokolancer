<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <?php if ($totalkeranjang >= 1) : ?>
            <?php foreach ($keranjang as $keranjang) : ?>
                <table class="shop_table shop_table_responsive cart">
                    <thead>
                        <tr>
                            <th class="product-remove">&nbsp;</th>
                            <th class="product-thumbnail">&nbsp;</th>
                            <th class="product-name">Produk</th>
                            <th class="product-name">Store</th>
                            <th class="product-price">Harga</th>
                            <th class="product-price">Jumlah</th>
                            <th class="product-quantity">Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="product-remove">
                                <a class="remove" href="#">×</a>
                            </td>
                            <td class="product-thumbnail">
                                <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url(); ?>/logotoko.png">
                            </td>
                            <td data-title="Product" class="product-name">
                                <div class="media cart-item-product-detail">
                                    <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url('img/produk') . '/' . $keranjang['gambar_produk']; ?>">
                                    <div class="media-body align-self-center">
                                        <a href="<?= base_url('produk/detail') . '/' . $keranjang['id_produk'] ?>">
                                            <strong><?= $keranjang['nama_produk'] ?></strong>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td data-title="Order Number" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span><i>@<?= $keranjang['nama_toko'] ?></i></span>
                                </span>
                            </td>
                            <td data-title="Nominal" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp. </span><?= number_format($keranjang['harga_produk']) ?>
                                </span>
                            </td>
                            <td data-title="Jumlah Pesanan" class="product-price">
                                <span>
                                    <?= $keranjang['jumlah'] ?>
                                </span>
                            </td>
                            <td data-title="Pesan ke penjual">
                                <span><?= $keranjang['pesan'] ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-12">
                    <form action="<?= base_url('user/order/keranjang') . '/' . $keranjang['id'] ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-danger delete-one" style="width: 100%;" data-nama="<?= $keranjang['nama_produk'] ?>">Hapus</button>
                    </form>
                </div>
                <hr style="border-top: 2px dashed green;">
            <?php endforeach; ?>
            <div class="row">
                <div class="col-6">
                    <form action="<?= base_url('user/order/semuakeranjang') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-danger delete-all" style="width: 100%;">Hapus Semua</button>
                    </form>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-success" data-toggle="modal" style="width: 100%;" data-target="#prosesModal">
                        Proses
                    </button>
                </div>
                </form>
            </div>
        <?php else : ?>
            <center>
                <div class="card w-75 mt-3 mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Ooops !</h5>
                        <p class="card-text">Keranjang masih kosong.</p>
                    </div>
                    <!-- .woocommerce -->
                </div>
            </center>
        <?php endif; ?>
    </div>
    <div class="modal fade" id="prosesModal" tabindex="-1" role="dialog" aria-labelledby="prosesModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="<?= base_url('user/order/proses') ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prosesModalTitle">Proses Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <?= csrf_field(); ?>
                            <span>Total Harga : </span> Rp. <?= number_format($totalharga) ?>
                            <div class="form-group">
                                <label for="metode">Metode Pembayaran</label>
                                <select id="metode" name="metode" class="form-control">
                                    <?php foreach ($pembayaran as $p) : ?>
                                        <?php if ($p['percent'] == '0.00') : ?>
                                            <option value="<?= $p['code'] ?>"><?= $p['nama'] . ' (Fee = Rp.' . number_format($p['flat']) . ')' ?></option>
                                        <?php else : ?>
                                            <option value="<?= $p['code'] ?>"><?= $p['nama'] . ' (Fee = Rp.' . number_format($p['flat']) . ' + ' . $p['percent'] . ' %)' ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(".delete-all").on('click', function(e) {
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Mau membersihkan keranjang belanja ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjut',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.form.submit();
            }
        })
    })
    $(".delete-one").on('click', function(e) {
        var nama = $(this).data('nama');
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Mau menghapus ' + nama + ' dari keranjang ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.form.submit();
            }
        })
    })
</script>
<?= $this->endSection(); ?>