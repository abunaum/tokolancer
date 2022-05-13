<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <?php if (user()->status_toko == 0) : ?>
            <?= $this->include('Toko/belum_daftar') ?>
        <?php elseif (user()->status_toko == 1) : ?>
            <?= $this->include('Toko/pending') ?>
        <?php elseif (user()->status_toko == 2) : ?>
            <?= $this->include('Toko/tunggu') ?>
        <?php elseif (user()->status_toko == 3) : ?>
            <?= $this->include('Toko/tolak') ?>
        <?php elseif (user()->status_toko == 4) : ?>
            <?= $this->include('Toko/acc') ?>
        <?php elseif (user()->status_toko == 5) : ?>
            <?= $this->include('Toko/bannedtoko') ?>
        <?php endif; ?>
    </div>
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>