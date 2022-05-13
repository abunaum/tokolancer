<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <div class="container-fluid">
            <!-- Page Heading -->
            <center>
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top rounded-circle" src="<?= base_url() ?>/img/profile/<?= user()->user_image; ?>" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-title"><b><?= user()->fullname; ?></b></h3>
                        <h5 class="card-title"><i>@<?= user()->username; ?></i></h5>
                        <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#ubahdataModal">Ubah Data
                        </button>
                        <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#passwordModal">Ubah Password
                        </button>
                    </div>
                </div>
            </center>
        </div>
    </div>
    <!-- .col-full -->
</section>
</div>
<!-- Modal -->
<div class="modal fade" id="ubahdataModal" tabindex="-1" aria-labelledby="ubahdataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahdataModalLabel">Ubah Data</h5>
            </div>
            <div class="modal-body">
                <center>
                    <form class="g-3 needs-validation" action="<?= base_url('user/ubahdata'); ?>" method="post" enctype="multipart/form-data" novalidate>
                        <?= csrf_field(); ?>
                        <img class="card-img-top rounded-circle col col-md-6 mb-3 lihat-gambar" src="<?= base_url() ?>/img/profile/<?= user()->user_image; ?>" alt="Card image cap">
                        <label for="gambar">Gambar tidak wajib di ubah</label>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="gambar" class=" form-control-label">Gambar</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" id="gambar" name="gambar" class="form-control-file <?= ($validation->hasError('gambar')) ? 'is-invalid' : '' ?>" onchange="profilpreview()">
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            <?= $validation->getError('gambar'); ?>
                        </div>
                        <div class="mt-4 col col-md-12">
                            <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" id="nama" name="nama" placeholder="Nama" value="<?php if (old('nama') != '') : ?><?= old('nama') ?><?php else : ?><?= user()->fullname ?><?php endif; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
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
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Ubah Password</h5>
            </div>
            <div class="modal-body">
                <center>
                    <form class="g-3 needs-validation" action="<?= base_url('user/ubahpassword'); ?>" method="post" novalidate>
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
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    function profilpreview() {
        const gambar = document.querySelector('#gambar');
        const previewimg = document.querySelector('.lihat-gambar');

        const filegambar = new FileReader();
        filegambar.readAsDataURL(gambar.files[0]);

        filegambar.onload = function(e) {
            previewimg.src = e.target.result;
        }
    }
</script>
<?= $this->endSection(); ?>