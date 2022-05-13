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
                            <td>Selogan Toko</td>
                            <td><i>"<?= $toko['selogan'] ?>"</i></td>
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
                            <td>Status Toko</td>
                            <td>
                                <?php if ($toko['status'] == 1) : ?>
                                    Buka
                                <?php else : ?>
                                    Tutup
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <div class="mb-2 mt-2">
                        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tokoModal">
                            Edit
                        </button>
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
                            <h5 class="modal-title" id="tokoModalLabel">Edit Toko</h5>
                        </center>
                        <button type="button" class="iconify" data-icon="clarity:window-close-line" data-inline="false" data-width="24px" data-height="24px" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="g-3 needs-validation" action="<?= base_url('toko/edittoko'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                            <center>
                                <img class="card-img-top rounded-circle col col-md-6 mb-3 lihat-gambar" src="<?= base_url('/img/toko') . '/' . $toko['logo']; ?>" alt="Card image cap">
                            </center>
                            <div class="row form-group mb-3">
                                <div class="col col-md-3">
                                    <label for="gambar" class=" form-control-label">Selogan</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control <?= ($validation->hasError('selogan')) ? 'is-invalid' : '' ?>" placeholder="Selogan Toko" aria-label="Selogan" name="selogan" id="selogan" aria-describedby="basic-addon1" value="<?= (old('selogan')) ? old('selogan') : $toko['selogan'] ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('selogan'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group mb-3">
                                <div class="col col-md-3">
                                    <label for="status" class=" form-control-label">Status</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="checkbox" <?= ($toko['status'] == 1) ? 'checked' : '' ?> data-toggle="toggle" data-size="sm" name="status" id="status">
                                </div>
                            </div>
                            <div class="row form-group mb-3">
                                <div class="col col-md-3">
                                    <label for="gambar" class=" form-control-label">Logo Toko</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="file" id="gambar" name="gambar" class="form-control-file <?= ($validation->hasError('gambar')) ? 'is-invalid' : '' ?>" onchange="profilpreview()">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
<script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/tombol-buka-tutup-rev-1.js"></script>
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