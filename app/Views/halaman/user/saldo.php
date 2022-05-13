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
                        <hr>
                        <h4 class="card-title"><strong>Saldo anda :</str>
                        </h4>
                        <h4 class="card-title"><strong>Rp. <?= number_format(user()->balance) ?></str>
                        </h4>
                        <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#saldoModal">Tambah Saldo
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
<div class="modal fade" id="saldoModal" tabindex="-1" aria-labelledby="saldoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saldoModalLabel">Tambah Saldo</h5>
            </div>
            <div class="modal-body">
                <center>
                    <form class="g-3 needs-validation" action="<?= base_url('user/tambahsaldo'); ?>" method="post" novalidate>
                        <?= csrf_field(); ?>
                        <div class="mt-4">
                            <label for="saldo">Minimal isi saldo Rp. 10.000</label>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                            <input type="number" class="form-control <?= ($validation->hasError('saldo')) ? 'is-invalid' : '' ?>" placeholder="10000" aria-label="saldo" name="saldo" id="saldo" aria-describedby="basic-addon1" value="<?= old('saldo') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('saldo'); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="channel">Metode Pembayaran</label>
                            <select class="form-control" aria-label="Default select example" id="channel" name="channel">
                                <?php
                                $pembayaran = $paymentapi->getmerchantclosed();
                                ?>
                                <?php foreach ($pembayaran as $p) : ?>
                                    <?php if ($p['percent'] == '0.00') : ?>
                                        <option value="<?= $p['code'] ?>"><?= $p['nama'] . ' (Fee = Rp.' . number_format($p['flat']) . ')' ?></option>
                                    <?php else : ?>
                                        <option value="<?= $p['code'] ?>"><?= $p['nama'] . ' (Fee = Rp.' . number_format($p['flat']) . ' + ' . $p['percent'] . ' %)' ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal
                            </button>
                            <button type="submit" class="btn btn-primary">Proses</button>
                        </div>
                    </form>
                </center>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>