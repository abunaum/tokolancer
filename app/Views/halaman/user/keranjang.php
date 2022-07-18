<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <?php if ($totalkeranjang >= 1) : ?>
            <?php foreach ($keranjang as $ker) : ?>
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
                                <button type="button" class="btn btn-danger delete-one" style="width: 100%;"
                                        data-nama="<?= $ker['nama_produk'] ?>">Hapus
                                </button>
                            </td>
                            <td class="product-thumbnail">
                                <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url(); ?>/logotoko.png">
                            </td>
                            <td data-title="Product" class="product-name">
                                <div class="media cart-item-product-detail">
                                    <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url('img/produk') . '/' . $ker['gambar_produk']; ?>">
                                    <div class="media-body align-self-center">
                                        <a href="<?= base_url('produk/detail') . '/' . $ker['id_produk'] ?>">
                                            <strong><?= $ker['nama_produk'] ?></strong>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td data-title="Order Number" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span><i>@<?= $ker['nama_toko'] ?></i></span>
                                </span>
                            </td>
                            <td data-title="Nominal" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp. </span><?= number_format($ker['harga_produk']) ?>
                                </span>
                            </td>
                            <td data-title="Jumlah Pesanan" class="product-price">
                                <span>
                                    <?= $ker['jumlah'] ?>
                                </span>
                            </td>
                            <td data-title="Pesan ke penjual">
                                <span><?= $ker['pesan'] == '' ? 'Tidak ada pesan' : $ker['pesan'] ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-6">
                        <form action="<?= base_url('user/order/keranjang') . '/' . $ker['id'] ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" class="btn btn-danger delete-one" style="width: 100%;"
                                    data-nama="<?= $ker['nama_produk'] ?>">Hapus
                            </button>
                        </form>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-warning" data-toggle="modal" style="width: 100%;" data-target="#editModal<?= $ker['id'] ?>">
                            Edit
                        </button>
                        <div class="modal fade" id="editModal<?= $ker['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModal<?= $ker['id'] ?>Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="<?= base_url('user/order/edit'.'/'. $ker['id']) ?>" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="prosesModalTitle">Edit Pesanan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div style="text-align: center;">
                                                <?= csrf_field(); ?>
                                                <span class="input-group mb-3">Nama Produk : <?= $ker['nama_produk'];?></span>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Jumlah</span>
                                                    </div>
                                                    <input type="number" class="form-control" placeholder="jumlah" aria-label="jumlah" name="jumlah" id="jumlah" value="<?= $ker['jumlah'] ?>">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Pesan</span>
                                                    </div>
                                                    <textarea class="form-control" placeholder="Pesan" name="pesan" id="pesan"><?=$ker['pesan'];?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($keranjang as $k) : ?>
                                <tr>
                                    <th scope="row"><?= $no;?></th>
                                    <td><?= $k['nama_produk'];?></td>
                                    <td><?= number_to_currency($k['harga_produk'], 'IDR', 'id_ID');?></td>
                                    <td><?= $k['jumlah'];?></td>
                                    <td><?= number_to_currency($k['harga_produk'] * $k['jumlah'], 'IDR', 'id_ID');?></td>
                                </tr>
                                <?php $no++; ?>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                            <span>Total Harga : </span> <?= number_to_currency($totalharga, 'IDR', 'id_ID');?>
                            <div class="form-group mb-3">
                                <label for="metode">Metode Pembayaran</label>
                                <select id="metode" name="metode" class="form-control mb-3" onchange="cekch()">
                                    <?php foreach ($pembayaran as $p) : ?>
                                        <?php if ($p['percent'] == '0.00') : ?>
                                            <option value="<?= $p['code'] ?>"><?= $p['nama'] . ' (Fee = ' . number_to_currency($p['flat'], 'IDR', 'id_ID') . ')' ?></option>
                                        <?php else : ?>
                                            <option value="<?= $p['code'] ?>"><?= $p['nama'] . ' (Fee = ' . number_to_currency($p['flat'], 'IDR', 'id_ID') . ' + ' . $p['percent'] . ' %)' ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="divovo" style="display: none">
                                <span>Nomor OVO</span>
                                <input type="number" class="form-control" placeholder="08xxxxxxxxxx" aria-label="noovo" name="noovo" id="noovo">
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
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    function cekch() {
        var ch = document.getElementById("metode").value;
        console.log(ch);
        var div = document.getElementById("divovo");
        if (ch === "OVO") {
            div.style.display = "block";
        } else {
            div.style.display = "none";
        }
    }
</script>
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