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
                    <h1>Pengajuan Pencairan Seller</h1>
                    <div style="overflow-x:auto;">
                        <table class="table table-striped">
                            <thead>
                            <td>#</td>
                            <td>Email</td>
                            <td>Metode</td>
                            <td>Nomor Rekening</td>
                            <td>Nama</td>
                            <td>Nominal</td>
                            <td>Aksi</td>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($pencairan as $p) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= $p['email']; ?></td>
                                    <td><?= $p['metode']; ?></td>
                                    <td><?= $p['no_rek']; ?></td>
                                    <td><?= $p['nama_rek']; ?></td>
                                    <td><?= $p['nominal']; ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-6">
                                            <button type="button" class="btn btn-success" data-toggle="modal" style="width: 100%;" data-target="#accModal<?= $p['id'] ?>">
                                                ACC
                                            </button>
                                            </div>
                                            <div class="col-6">
                                            <button type="button" class="btn btn-danger" data-toggle="modal" style="width: 100%;" data-target="#tolakModal<?= $p['id'] ?>">
                                                Tolak
                                            </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <?= $pager->links(); ?>
                </center>
            </div>
        </div>
    </div>
<?php foreach ($pencairan as $p) : ?>
    <div class="modal fade" id="accModal<?= $p['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="accModal<?= $p['id'] ?>Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="<?= base_url('admin/pencairan/acc'.'/'. $p['id']) ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prosesModalTitle">ACC Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <?= csrf_field(); ?>
                            <table class="table mb-3">
                                <tbody>
                                        <tr>
                                            <td>Metode Pembayaran</td>
                                            <td><?= $p['metode']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nomor Rekening</td>
                                            <td><?= $p['no_rek']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Rekening</td>
                                            <td><?= $p['nama_rek']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nominal</td>
                                            <td><?= number_to_currency($p['nominal'], 'IDR','id_ID',0); ?></td>
                                        </tr>
                                </tbody>
                            </table>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Info</span>
                                </div>
                                <textarea class="form-control" placeholder="Nomor Referensi : xxxxxx" name="info" id="info"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">ACC</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tolakModal<?= $p['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="tolakModal<?= $p['id'] ?>Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="<?= base_url('admin/pencairan/tolak'.'/'. $p['id']) ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prosesModalTitle">Tolak Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <?= csrf_field(); ?>
                            <table class="table mb-3">
                                <tbody>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td><?= $p['metode']; ?></td>
                                </tr>
                                <tr>
                                    <td>Nomor Rekening</td>
                                    <td><?= $p['no_rek']; ?></td>
                                </tr>
                                <tr>
                                    <td>Nama Rekening</td>
                                    <td><?= $p['nama_rek']; ?></td>
                                </tr>
                                <tr>
                                    <td>Nominal</td>
                                    <td><?= number_to_currency($p['nominal'], 'IDR','id_ID',0); ?></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Info</span>
                                </div>
                                <textarea class="form-control" placeholder="Alasan" name="info" id="info"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach;?>
    <!-- /.container-fluid -->
<?= $this->endSection(); ?>