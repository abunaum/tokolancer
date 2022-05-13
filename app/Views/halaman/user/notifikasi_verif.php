<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <div class="container-fluid">

            <!-- Page Heading -->
            <center>
                <h1>Konfirmasi Kode Telegram</h1>
                <div class="card" style="width: 30rem;">
                    <form class="g-3 needs-validation mt-3" action="<?= base_url('user/notifikasi/veriftele'); ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                            <h4>Telegram ID anda <?= $tele; ?></h4>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control <?= ($validation->hasError('kode')) ? 'is-invalid' : '' ?>" placeholder="xxxxxxxx" aria-label="kode" name="kode" id="kode" aria-describedby="basic-addon1" value="<?= old('kode') ?>" style="text-transform:uppercase">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kode'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#teleModal">Ubah ID</a>
                            <a href="<?= base_url('user/notifikasi/kirimteleulang') ?>" class="btn btn-warning">Kirim ulang kode</a>
                            <button type="submit" class="btn btn-primary">Konfirmasi</button>
                        </div>
                        <p>Tidak mendapat kode? pastikan chat <a href="https://t.me/TokoLancer_bot" target="_blank" rel="noopener noreferrer">@TokoLancer_bot</a></p>
                    </form>
                </div>
            </center>
            <div class="modal fade" id="teleModal" tabindex="-1" aria-labelledby="teleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="teleModalLabel">Ubah Telegram</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <center>
                                <form class="row g-3 needs-validation" action="<?= base_url('user/notifikasi/ubahtele'); ?>" method="post" novalidate>
                                    <?= csrf_field() ?>
                                    <div class="modal-body">
                                        <p>Untuk mendapatkan Telegram ID silahkan chat <a href="https://t.me/TokoLancer_bot" target="_blank" rel="noopener noreferrer">@TokoLancer_bot</a></p>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control <?= ($validation->hasError('teleid')) ? 'is-invalid' : '' ?>" placeholder="Telegram Id" aria-label="teleid" name="teleid" id="teleid" aria-describedby="basic-addon1" value="<?= old('teleid') ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('teleid'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                    </div>
                                </form>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>