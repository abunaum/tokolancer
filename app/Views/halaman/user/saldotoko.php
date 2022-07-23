<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
    <section class="stretch-full-width">
        <div class="col-full">
            <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
            <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
            <center>
                <div class="card w-75">
                    <div class="card-body">
                        <div class="dropdown-list-image mr-3 mb-2">
                            <img class="rounded-circle" src="<?= base_url('/img/toko') . '/' . $toko['logo'] ?>" alt="logo">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <table class="table table-striped">
                            <tr>
                                <td>Username Toko</td>
                                <td><?= $toko['username'] ?></td>
                            </tr>
                            <tr>
                                <td>Metode Pencairan</td>
                                <td style="text-transform: uppercase;"><?= $toko['metode'] ?></td>
                            </tr>
                            <tr>
                                <td>Nomor Rekening</td>
                                <td><?= $toko['no_rek'] ?></td>
                            </tr>
                            <tr>
                                <td>Nama Rekening</td>
                                <td><?= $toko['nama_rek'] ?></td>
                            </tr>
                            <tr>
                                <td>Saldo</td>
                                <td><?= number_to_currency(user()->balance,'IDR', 'id_ID') ?></td>
                            </tr>
                        </table>
                        <div class="mb-2 mt-2">
                            <?php if(user()->balance >= ($cair['minimal'] + $cair['fee'])):?>
                            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tokoModal">
                                Request pencairan
                            </button>
                            <?php else: ?>
                            Saldo tidak mencukupi untuk pencairan dana, minimal saldo untuk pencairan adalah <?= number_to_currency($cair['minimal'],'IDR', 'id_ID'); ?> + fee : <?= number_to_currency($cair['fee'],'IDR', 'id_ID'); ?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </center>
            <!-- Modal -->
            <!-- Modal -->
            <div class="modal fade" id="tokoModal" tabindex="-1" aria-labelledby="tokoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h5 class="modal-title" id="tokoModalLabel">Cairkan Dana</h5>
                            </center>
                            <button type="button" class="iconify" data-icon="clarity:window-close-line" data-inline="false" data-width="24px" data-height="24px" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="g-3 needs-validation" action="<?= base_url('user/toko/cairkan'); ?>" method="post" id="form-cair" name="form-cair">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Metode Pencairan</td>
                                            <td><?= $toko['metode'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nomor Rekening</td>
                                            <td><?= $toko['no_rek'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Rekening</td>
                                            <td><?= $toko['nama_rek'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Saldo</td>
                                            <td><?= number_to_currency(user()->balance,'IDR', 'id_ID') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Fee Pencairan</td>
                                            <td><?= number_to_currency($cair['fee'],'IDR', 'id_ID') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Bisa dicairkan</td>
                                            <td><?= number_to_currency((user()->balance - $cair['fee']),'IDR', 'id_ID') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div style="text-align: center;">
                                <label>Masukkan Nominal Pencairan</label>
                                </div>
                                <input type="number" name="nominal" id="nominal" class="form-control" placeholder="50000">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary tmbl-cairkan">Cairkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- .col-full -->
    </section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(".tmbl-cairkan").on('click', function(e) {
        var nominal = document.getElementById('nominal').value;
        var bisacair = <?= user()->balance - $cair['fee'];?>;
        minimal = <?= $cair['minimal'];?>;
        if (nominal < minimal) {
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Ooops!',
                html: 'Minimal pencairan saldo adalah ' + minimal,
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
        } else if (nominal > bisacair){
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Ooops!',
                html: 'Saldo yang bisa dicairkan adalah ' + bisacair,
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
        } else {
            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            });

            fixnominal = formatter.format(nominal);
            gass = document.getElementById('form-cair');
            Swal.fire({
                title: 'Anda yakin?',
                text: 'ingin mencairkan saldo ' + fixnominal + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjut',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    gass.submit();
                }
            })
        }
    })
</script>
<?= $this->endSection(); ?>
