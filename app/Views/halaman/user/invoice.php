<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
    <section class="stretch-full-width">
        <div class="col-full">
            <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
            <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
            <?php if ($total_invoice >= 1) : ?>
                <?php foreach ($invoice as $inv) : ?>
                    <table class="shop_table shop_table_responsive cart">
                        <thead>
                        <tr>
                            <th class="product-remove">&nbsp;</th>
                            <th class="product-thumbnail">&nbsp;</th>
                            <th class="product-name">Kode</th>
                            <th class="product-name">Channel</th>
                            <th class="product-price">Nominal</th>
                            <th class="product-price">Fee</th>
                            <th class="product-quantity">Total</th>
                            <th class="product-quantity">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="product-remove">
                                <button type="button" class="btn btn-danger delete-one" style="width: 100%;"
                                        data-nama="<?= $inv['kode']; ?>">Hapus
                                </button>
                            </td>
                            <td data-title="Kode" class="product-name">
                                <div class="media cart-item-product-detail">
                                    <div class="media-body align-self-center">
                                        <strong><?= $inv['kode']; ?></strong>
                                    </div>
                                </div>
                            </td>
                            <td data-title="Channel" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span><i><?= $inv['payment']['channel']; ?></i></span>
                                </span>
                            </td>
                            <td data-title="Nominal" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp. </span><?= number_format($inv['payment']['nominal']); ?>
                                </span>
                            </td>
                            <td data-title="Fee" class="product-price">
                                <span>
                                    <?= number_format($inv['payment']['fee']); ?>
                                </span>
                            </td>
                            <td data-title="Nominal">
                                <span><?= number_format($inv['payment']['nominal'] + $inv['payment']['fee']); ?></span>
                            </td>
                            <td data-title="Status">
                                <span><?= $inv['payment']['status']; ?></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-<?= $inv['payment']['status'] == 'UNPAID' ? '6' : '12';?>">
                            <form action="<?= base_url('user/order/invoice') . '/' . $inv['payment']['id'] ?>" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="button" class="btn btn-danger delete-one" style="width: 100%;"
                                        data-nama="<?= $inv['kode']; ?>">Hapus
                                </button>
                            </form>
                        </div>
                        <?php if ($inv['payment']['status'] == 'UNPAID') : ?>
                            <div class="col-6">
                                <form action="<?= base_url('user/order/bayar') . '/' . $inv['payment']['id']; ?>"
                                      method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-success" style="width: 100%;">
                                        Bayar
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                    <hr style="border-top: 2px dashed green;">
                <?php endforeach; ?>
            <?php else : ?>
                <center>
                    <div class="card w-75 mt-3 mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Ooops !</h5>
                            <p class="card-text">Invoice kosong.</p>
                        </div>
                        <!-- .woocommerce -->
                    </div>
                    <hr style="border-top: 2px dashed green;">
                </center>
            <?php endif; ?>
            <center>
                <h1>Data Transaksi</h1>
                <?php foreach ($transaksi as $ter) : ?>
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
                            <th class="product-quantity">Status</th>
                            <th class="product-quantity">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="product-remove">
                                <button type="button" class="btn btn-danger delete-one" style="width: 100%;"
                                        data-nama="<?= $ter['nama_produk'] ?>">Hapus
                                </button>
                            </td>
                            <td class="product-thumbnail">
                                <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url(); ?>/logotoko.png">
                            </td>
                            <td data-title="Product" class="product-name">
                                <div class="media cart-item-product-detail">
                                    <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url('img/produk') . '/' . $ter['gambar_produk']; ?>">
                                    <div class="media-body align-self-center">
                                        <a href="<?= base_url('produk/detail') . '/' . $ter['id_produk'] ?>">
                                            <strong><?= $ter['nama_produk'] ?></strong>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td data-title="Order Number" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span><i>@<?= $ter['nama_toko'] ?></i></span>
                                </span>
                            </td>
                            <td data-title="Nominal" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp. </span><?= number_format($ter['harga_produk']) ?>
                                </span>
                            </td>
                            <td data-title="Jumlah Pesanan" class="product-price">
                                <span>
                                    <?= $ter['jumlah'] ?>
                                </span>
                            </td>
                            <td data-title="Pesan ke penjual">
                                <span><?= $ter['pesan'] == '' ? 'Tidak ada pesan' : $ter['pesan'] ?></span>
                            </td>
                            <?php
                            if ($ter['status'] == 3){
                                $status = 'Menunggu dikirim';
                            }
                            elseif ($ter['status'] == 4){
                                $status = 'Ditolak Seller';
                            }
                            elseif ($ter['status'] == 5){
                                $status = 'Dikirim';
                            }
                            elseif ($ter['status'] == 6){
                                $status = 'selesai';
                            }
                            else {
                                $status = 'Produk bermasalah';
                            }
                            ?>
                            <td data-title="Status">
                                <span><?= $status;?></span>
                            </td>
                            <td data-title="Aksi">
                                <form action="<?= base_url('user/order/canceltransaksi') . '/' . $ter['id'] ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="button" class="btn btn-danger delete-one" style="width: 100%;"
                                            data-nama="<?= $ter['nama_produk'] ?>">Batalkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr style="border-top: 2px dashed green;">
                <?php endforeach; ?>
            </center>
        </div>
    </section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
    <script>
        $(".delete-all").on('click', function(e) {
            Swal.fire({
                title: 'Anda yakin?',
                text: 'Mau membersihkan invoice ?',
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
<?php if (session('error')) :?>
    <script>
        const error = '<?= session('error');?>';
        let timerInterval
        Swal.fire({
            icon: 'error',
            title: 'Maaf',
            html: error,
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
        })
    </script>
<?php elseif (session('sukses')) : ?>
    <script>
        const pesan = '<?= session('sukses');?>';
        let timerInterval
        Swal.fire({
            icon: 'success',
            title: 'Mantap',
            html: pesan,
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
        })
    </script>
<?php endif; ?>

<?= $this->endSection(); ?>