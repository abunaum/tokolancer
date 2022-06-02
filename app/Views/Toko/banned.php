<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <center>
            <div class="card w-75">
                <div class="card-body">
                    <h5 class="card-title">Ooops !</h5>
                    <p class="card-text">Toko anda di bekukan.</p>
                    <hr>
                    <p>Toko anda melanggar sarat dan ketentuan berjualan di <?= $_SERVER['HTTP_HOST'] ?>.</p>
                    Silahkan hubungi kami agar anda bisa berjualan lagi.
                    <hr>
                </div>
            </div>
        </center>
    </div>
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>