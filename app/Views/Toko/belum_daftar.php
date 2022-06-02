<center>
    <div class="card w-75">
        <div class="card-body">
            <h5 class="card-title">Ooops !</h5>
            <p class="card-text">Anda belum mempunyai toko.</p>
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tokoModal">
                Buat toko Sekarang
            </button>
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
                    <h5 class="modal-title" id="tokoModalLabel">Buat Toko</h5>
                </center>
                <button type="button" class="iconify" data-icon="clarity:window-close-line" data-inline="false"
                        data-width="24px" data-height="24px" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="g-3 needs-validation" action="<?= base_url('toko/buattoko');?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <label class="form-label">Gambar Toko</label>
                    <div class="input-group mb-3">
                        <input class="form-control <?= ($validation->hasError('logo')) ? 'is-invalid' : '' ?>" type="file" id="logo" name="logo">
                        <div class="invalid-feedback">
                            <?= $validation->getError('logo'); ?>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" placeholder="Username Toko" aria-label="Username" name="username" id="username" aria-describedby="basic-addon1" value="<?= old('username') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('username'); ?>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('selogan')) ? 'is-invalid' : '' ?>" name="selogan" id="selogan" placeholder="Selogan Toko" aria-label="Selogan Toko" aria-describedby="basic-addon2" value="<?= old('selogan') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('selogan'); ?>
                        </div>
                    </div>

                    <label for="basic-url" class="form-label">Metode Pencairan</label>
                    <div class="input-group mb-3">
                        <select class="input-group form-select form-select-lg" id="metode" name="metode" aria-label="Default select example">
                            <option value="ovo">OVO</option>
                            <option value="gopay">GoPay</option>
                            <option value="dana">Dana</option>
                            <option value="bank bca">Bank BCA</option>
                            <option value="bank bri">Bank BRI</option>
                            <option value="bank">Bank Mandiri</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Buat</button>
                </div>
            </form>

        </div>
    </div>
</div>