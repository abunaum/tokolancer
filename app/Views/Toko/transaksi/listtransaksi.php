<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <?php if ($total_paid >= 1) : ?>
            <?php foreach ($paid as $p) : ?>
                <table class="shop_table shop_table_responsive cart">
                    <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-thumbnail">&nbsp;</th>
                        <th class="product-name">Kode</th>
                        <th class="product-name">Nama Produk</th>
                        <th class="product-price">Jumlah Order</th>
                        <th class="product-quantity">Status</th>
                        <th class="product-quantity">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="product-remove">
                            <button type="button" class="btn btn-danger delete-one" style="width: 100%;"
                                    data-nama="<?= $p['id']; ?>">Tolak
                            </button>
                        </td>
                        <td data-title="Kode" class="product-name">
                            <div class="media cart-item-product-detail">
                                <div class="media-body align-self-center">
                                    <strong><?= $p['invoice']; ?></strong>
                                </div>
                            </div>
                        </td>
                        <td data-title="Nama Produk">
                            <span><?= $p['nama_produk']; ?></span>
                        </td>
                        <td data-title="Nominal" class="product-price">
                            <?= $p['jumlah']; ?>
                        </td>
                        <td data-title="Status">
                            <span>Menunggu di kirim</span>
                        </td>
                        <td data-title="Aksi">
                            <?php $id = $p['id'];?>
                            <form action="<?= base_url('user/toko/batalkan') . '/' . $p['id'] ?>" method="post" id="form-hapus-<?= $p['id'];?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="button" class="btn btn-danger" style="width: 100%;" onclick="hapuspesanan('<?= $id;?>')">Tolak
                                </button>
                            </form>
                            <button type="button" class="btn btn-success" data-toggle="modal" style="width: 100%;" data-target="#editModal<?= $p['id'] ?>">
                                Kirim
                            </button>
                            <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModal<?= $p['id'] ?>Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form action="<?= base_url('user/toko/kirim'.'/'. $p['id']) ?>" method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="prosesModalTitle">Kirim Pesanan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="text-align: center;">
                                                    <?= csrf_field(); ?>
                                                    <span class="input-group mb-3">Nama Produk : <?= $p['nama_produk'];?></span>
                                                    <span class="input-group mb-3">Pesan : <?= $p['pesan'] == '' ? 'Tidak ada pesan' : $p['pesan'] ;?></span>
                                                    <span class="input-group mb-3">Jumlah Pesanan : <?= $p['jumlah'];?></span>
                                                    <span class="input-group mb-3">Pembeli : <?= $p['email_buyer'];?></span>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">Detail</span>
                                                        </div>
                                                        <textarea class="form-control" placeholder="Masukkan detail pesanan seperti informasi akun (jika produk berupa akun) " name="pesan" id="pesan"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <hr style="border-top: 2px dashed green;">
            <?php endforeach; ?>
        <?php else : ?>
            <center>
                <div class="card w-75 mt-3 mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Ooops !</h5>
                        <p class="card-text">Transaksi kosong.</p>
                    </div>
                    <!-- .woocommerce -->
                </div>
                <hr style="border-top: 2px dashed green;">
            </center>
        <?php endif; ?>
        <?php if (count($riwayat) >= 1) : ?>
        <h5>Transaksi Terproses</h5>
            <?php foreach ($riwayat as $r) : ?>
                <table class="shop_table shop_table_responsive cart">
                    <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-thumbnail">&nbsp;</th>
                        <th class="product-name">Kode</th>
                        <th class="product-name">Nama Produk</th>
                        <th class="product-price">Jumlah Order</th>
                        <th class="product-quantity">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="product-remove">
                            <button type="button" class="btn btn-danger delete-one" style="width: 100%;"
                                    data-nama="<?= $r['id']; ?>">Tolak
                            </button>
                        </td>
                        <td data-title="Kode" class="product-name">
                            <div class="media cart-item-product-detail">
                                <div class="media-body align-self-center">
                                    <strong><?= $r['invoice']; ?></strong>
                                </div>
                            </div>
                        </td>
                        <td data-title="Nama Produk">
                            <span><?= $r['nama']; ?></span>
                        </td>
                        <td data-title="Nominal" class="product-price">
                            <?= $r['jumlah']; ?>
                        </td>
                        <td data-title="Status">
                            <span>
                                <?php
                                if ($r['status'] == 1){
                                    echo "Dikirim, Menunggu respon buyer";
                                }
                                elseif ($r['status'] == 2){
                                    echo "Terkirim, Menunggu konfirmasi seller";
                                }
                                elseif ($r['status'] == 3){
                                    echo "Transaksi Selesai";
                                }
                                else{
                                    echo 'Bermasalah, Harap hubungi <a href="https://t.me/abu_naum">CS</a>';
                                }
                                ?>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <hr style="border-top: 1px dashed black;">
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    function hapuspesanan(idnya) {
        data = <?= json_encode($paid);?>;
        newdata = data.filter(x => x.id === idnya);
        sdata = newdata[0];
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Ingin membatalkan pesanan "'+sdata['nama_produk']+'" ('+ sdata['invoice'] +') ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjut',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("form-hapus-"+idnya).submit();
            }
        })
    }
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
