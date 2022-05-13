<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <div class="container-fluid">

            <!-- Page Heading -->
            <center>
                <div class="card w-75">
                    <div class="card-body">
                        <h5 class="card-title">Ooops !</h5>
                        <p class="card-text">Telegram belum di konfirmasi.</p>
                        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tokoModal">
                            Konfirmasi Sekarang
                        </button>
                    </div>
                </div>
            </center>
            <!-- Modal -->
            <div class="modal fade" id="tokoModal" tabindex="-1" aria-labelledby="tokoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h5 class="modal-title" id="tokoModalLabel">Konfirmasi Telegram</h5>
                            </center>
                            <button type="button" class="iconify" data-icon="clarity:window-close-line" data-inline="false" data-width="24px" data-height="24px" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="g-3 needs-validation" action="<?= base_url('user/notifikasi'); ?>" method="post">
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

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>