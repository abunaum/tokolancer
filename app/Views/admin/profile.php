<?= $this->extend('mypanel/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
            <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
            <!-- Page Heading -->
            <center>
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top rounded-circle" src="<?= base_url() ?>/img/profile/<?= user()->user_image; ?>" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-title"><b><?= user()->fullname; ?></b></h3>
                        <h5 class="card-title"><i>@<?= user()->username; ?></i></h5>
                        <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#passwordModal">Ubah Nama
                        </button>
                        <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#passwordModal">Ubah Password
                        </button>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true" style="z-index: 99999999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <form class="g-3 needs-validation" action="<?= base_url('admin/ubahpassword'); ?>" method="post" novalidate>
                        <?= csrf_field(); ?>
                        <div class="mt-4">
                            <input type="password" class="form-control <?= ($validation->hasError('passwordlama')) ? 'is-invalid' : '' ?>" id="passwordlama" name="passwordlama" placeholder="password lama" value="<?= old('passwordlama') ?>" autofocus>
                            <div class="invalid-feedback">
                                <?= $validation->getError('passwordlama'); ?>
                            </div>
                        </div>
                        <div class="mt-4">
                            <input type="password" class="form-control <?= ($validation->hasError('passwordbaru')) ? 'is-invalid' : '' ?>" id="passwordbaru" name="passwordbaru" placeholder="password baru" value="<?= old('passwordbaru') ?>" autofocus>
                            <div class="invalid-feedback">
                                <?= $validation->getError('passwordbaru'); ?>
                            </div>
                        </div>
                        <div class="mt-4">
                            <input type="password" class="form-control <?= ($validation->hasError('ulangipassword')) ? 'is-invalid' : '' ?>" id="ulangipassword" name="ulangipassword" placeholder="ulangi password" value="<?= old('ulangipassword') ?>" autofocus>
                            <div class="invalid-feedback">
                                <?= $validation->getError('ulangipassword'); ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </center>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>