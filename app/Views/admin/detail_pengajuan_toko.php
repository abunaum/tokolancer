<?= $this->extend('mypanel/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <center>
                <div class="card">
                    <center class="mt-3">
                        <img class="card-img-top rounded-circle" src="<?= base_url() ?>/img/toko/<?= $toko->logo; ?>" alt="Logo Toko" style="width:10em;height:10em;">
                    </center>
                    <div class=" card-body">
                        <h3 class="card-title"><b>&#64;<?= $toko->username; ?></b></h3>
                        <h5 class="card-title"><i>&#64;<?= $toko->username_user; ?></i></h5>
                        <p><i>&quot; <?= $toko->selogan; ?> &quot;</i></p>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Telegram ID</td>
                                    <?php if ($toko->telecode != 'valid') : ?>
                                        <td>
                                            <span class="badge badge-pill badge-danger">Belum verifikasi Telegram</span>
                                        </td>
                                    <?php else : ?>
                                        <td><?= $toko->teleid; ?></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <td>Metode Pencairan</td>
                                    <td><?= $toko->metode; ?></td>
                                </tr>
                                <tr>
                                    <td>Nomor Rekening</td>
                                    <td><?= $toko->no_rek; ?></td>
                                </tr>
                                <tr>
                                    <td>Foto Kartu</td>
                                    <form target="_blank" action="<?= base_url('admin/download/kartu') . '/' . $toko->id ?>" method="post">
                                        <?= csrf_field() ?>
                                        <td>
                                            <button type="submit" class="btnhilang">
                                                <span class="iconify" data-icon="ant-design:cloud-download-outlined" data-inline="false" style="color: green;" data-width="24" data-height="24"></span>
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                                <tr>
                                    <td>Foto Selfi</td>
                                    <form target="_blank" action="<?= base_url('admin/download/selfi') . '/' . $toko->id ?>" method="post">
                                        <?= csrf_field() ?>
                                        <td>
                                            <button type="submit" class="btnhilang">
                                                <span class="iconify" data-icon="ant-design:cloud-download-outlined" data-inline="false" style="color: green;" data-width="24" data-height="24"></span>
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <form class="col-2 d-inline" action="<?= base_url('admin/toko/acc') . '/' . $toko->id; ?>" method="post">
                            <button type="button" class="btn btn-success tmbl-acc" data-nama="<?= $toko->username ?>">ACC</button>
                        </form>
                        <form class="col-2 d-inline" action="<?= base_url('admin/toko/tolak') . '/' . $toko->id; ?>" method="post">
                            <button type="button" class="btn btn-danger tmbl-tolak" data-nama="<?= $toko->username ?>">Tolak</button>
                        </form>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>