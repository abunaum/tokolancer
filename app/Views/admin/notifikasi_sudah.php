<?= $this->extend('mypanel/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <div class="container-fluid">

            <!-- Page Heading -->
            <center>
                <div class="card w-75">
                    <div class="card-body">
                        <h5 class="card-title">Mantap</h5>
                        <p class="card-text">Notifikasi terhubung ke nomor Telegram ID <?= user()->teleid ?></p>
                        <button type="button" class="btn btn-danger mb-3" data-toggle="modal" data-target="#teleModal">
                            Ubah ID
                        </button>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
<div class="modal fade" id="teleModal" tabindex="-1" aria-labelledby="teleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teleModalLabel">Ubah Telegram</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <form class="row g-3 needs-validation" action="<?= base_url('admin/ubahtele'); ?>" method="post" novalidate>
                        <?= csrf_field() ?>
                        <div class="modal-body">
                            <p>Untuk mendapatkan Telegram ID silahkan chat <a href="https://t.me/TokoLancer_bot" target="_blank" rel="noopener noreferrer">@TokoLancer_bot</a></p>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control <?= ($validation->hasError('teleid')) ? 'is-invalid' : '' ?>" placeholder="Telegram ID" aria-label="teleid" name="teleid" id="teleid" aria-describedby="basic-addon1" value="<?= old('teleid') ?>">
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
<!-- /.container-fluid -->
<?= $this->endSection(); ?>