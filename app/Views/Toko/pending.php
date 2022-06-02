<center>
    <div class="card w-75">
        <div class="card-body">
            <div class="dropdown-list-image mr-3">
                <img class="rounded-circle" src="<?= base_url('/img/toko') . '/' . $toko[0]['logo'] ?>" alt="logo">
                <div class="status-indicator bg-success"></div>
            </div>
            <h2><?= $toko[0]['username'] ?></h2>
            <div>
                <i>"<?= $toko[0]['selogan'] ?>"</i>
            </div>
            Toko anda belum di aktivasi, untuk memulai berjualan harap aktivasi toko anda terlebih dahulu.
            <div class="mb-2 mt-2">
                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tokoModal">
                    Aktivasi
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
                    <h5 class="modal-title" id="tokoModalLabel">Aktivasi Toko</h5>
                </center>
                <button type="button" class="iconify" data-icon="clarity:window-close-line" data-inline="false" data-width="24px" data-height="24px" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="g-3 needs-validation" action="<?= base_url('toko/aktivasitoko'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <label class="form-label">Nama pada rekening</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" placeholder="Nama pada rekening" aria-label="Nama" name="nama" id="nama" aria-describedby="basic-addon1" value="<?= old('nama') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    </div>

                    <label class="form-label">Nomor rekening / pembayaran <?= $toko[0]['metode']; ?></label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control <?= ($validation->hasError('rekening')) ? 'is-invalid' : '' ?>" name="rekening" id="rekening" placeholder="123456677889" aria-label="Selogan Toko" aria-describedby="basic-addon2" value="<?= old('rekening') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('rekening'); ?>
                        </div>
                    </div>

                    <label class="form-label">Foto KTP / Kartu Pelajar</label>
                    <div class="input-group mb-3">
                        <input class="form-control <?= ($validation->hasError('kartu')) ? 'is-invalid' : '' ?>" type="file" id="kartu" name="kartu">
                        <div class="invalid-feedback">
                            <?= $validation->getError('kartu'); ?>
                        </div>
                    </div>
                    <label class="form-label">Foto Selfi Bersama Kartu</label>
                    <div class="input-group mb-3">
                        <input class="form-control <?= ($validation->hasError('selfi')) ? 'is-invalid' : '' ?>" type="file" id="selfi" name="selfi">
                        <div class="invalid-feedback">
                            <?= $validation->getError('selfi'); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Aktifkan Toko</button>
                </div>
            </form>

        </div>
    </div>
</div>