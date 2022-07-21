<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
    <section class="mb-5 stretch-full-width">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <hr class="mb-2" style="border-top: 2px dashed green;">
        <center>
        <h1>Detail Transaksi</h1>
        </center>
        <hr class="mb-2" style="border-top: 2px dashed green;">
        <div class="col-full">
            <div class="row mb-3">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div id="mdb-lightbox-ui"></div>
                    <div class="mdb-lightbox">
                        <div class="row product-gallery mx-1">
                            <div class="col-12 mb-0">
                                <figure class="view overlay rounded z-depth-1 main-img">
                                    <img src="<?= base_url(); ?>/img/produk/<?= $transaksi->gambar; ?>" class="img-thumbnail z-depth-1">
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mb-3" style="background-color: #dce0e0;">
                    <center class="mt-3">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th scope="row">Nama Produk</th>
                                <td><?= $transaksi->nama; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Toko</th>
                                <td>@<?= $transaksi->username; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Harga</th>
                                <td>@<?= $transaksi->harga; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Jumlah Order</th>
                                <td><?= $transaksi->jumlah; ?></td>
                            </tr>
                            <?php if ($transaksi->status_kiriman == 3) : ?>
                                <tr>
                                    <th scope="row">Status Transaksi</th>
                                    <td>Selesai</td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($transaksi->status_kiriman == 4) : ?>
                                <tr>
                                    <th scope="row">Status Transaksi</th>
                                    <td>Bermasalah (<?= $transaksi->invoice.'-'.$transaksi->id;?>)</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <hr>
                        <div class="mb-3">
                            <h5>Detail Pesanan</h5>
                            <?php if ($transaksi->status_kiriman != 1) : ?>
                                <hr class="mb-2" style="border-top: 2px dashed green;">
                                <p>
                                    <?= nl2br($transaksi->detail) ?>
                                </p>
                                <hr class="mb-2" style="border-top: 2px dashed green;">
                                <?php if ($transaksi->status_kiriman == 2) : ?>
                                    <form action="<?= base_url('user/order/transaksibermasalah') . '/' . $transaksi->id ?>"
                                          method="post">
                                        <?= csrf_field() ?>
                                        <button type="button" class="btn btn-danger pesanan-bermasalah" style="width: 100%;"
                                                data-nama="<?= $transaksi->nominal_transaksi; ?>">Pesanan bermasalah
                                        </button>
                                    </form>
                                    <form action="<?= base_url('user/order/transaksiselesai') . '/' . $transaksi->id ?>"
                                          method="post">
                                        <?= csrf_field() ?>
                                        <button type="button" class="btn btn-success pesanan-sesuai" style="width: 100%;"
                                                data-nama="<?= $transaksi->nominal_transaksi; ?>">Pesanan Sesuai
                                        </button>
                                    </form>
                                <?php elseif ($transaksi->status_kiriman == 4):?>
                                    <form action="<?= 'https://t.me/abu_naum'; ?>" method="get">
                                        <button type="submit" class="btn btn-success" style="width: 100%;">Hubungi CS
                                        </button>
                                    </form>
                                <?php endif; ?>
                            <?php else : ?>
                                <form action="<?= base_url('user/order/updatetransaksi') . '/' . $transaksi->id ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="button" class="btn btn-success ubah-status" style="width: 100%;"
                                            data-nama="<?= $transaksi->nama; ?>">Lihat Pesanan
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(".pesanan-sesuai").on('click', function(e) {
        var nama = $(this).data('nama');
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        });

        nominal = formatter.format(nama);
        Swal.fire({
            title: 'Lepaskan dana ke seller',
            text: 'Anda yakin ingin melepaskan dana '+ nominal +' ke seller?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1cad43',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lepaskan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.form.submit();
            }
        })
    })
    $(".pesanan-bermasalah").on('click', function(e) {
        var nama = $(this).data('nama');
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        });

        nominal = formatter.format(nama);
        Swal.fire({
            title: 'Pesanan bermasalah?',
            text: 'Anda yakin ingin menahan dana '+ nominal +' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1cad43',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Pesanan bermasalah',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.form.submit();
            }
        })
    })
    $(".ubah-status").on('click', function(e) {
        var nama = $(this).data('nama');
        Swal.fire({
            title: 'Perhatian!',
            text: 'Harap merekam terlebih dahulu sebagai bukti apabila pesanan tidak sesuai atau bermasalah',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1cad43',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjut lihat pesanan',
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
