<?= $this->extend('mypanel/template'); ?>
<?= $this->section('content'); ?>
    <!-- Begin Page Content -->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">

                <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
                <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
                <center>
                    <div class="mb-3">
                        <h1>Setting</h1>
                        <hr style="border-top: 2px dashed green;">
                    </div>
                    <div class="mb-3">
                        <table class="table table-striped">
                            <div class="mb-3">
                                <h3>Google Auth</h3>
                            </div>
                            <tbody>
                            <tr>
                                <th scope="row">ID</th>
                                <td><?= $config['gauth']['id']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Secret</th>
                                <td><?= $config['gauth']['secret']; ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mb-3 mt-3">
                            <button type="button" class="btnhilang mb-1" data-toggle="modal" data-target="#gauthModal">
                                <span class="iconify mb-3" data-icon="bxs:edit" data-inline="false"
                                      style="color: green;" data-width="30" data-height="30"></span>
                            </button>
                        </div>
                        <hr style="border-top: 2px dashed green;">
                    </div>
                    <div class="mb-3">
                        <table class="table table-striped">
                            <div class="mb-3">
                                <h3>Payment Gateway</h3>
                            </div>
                            <tbody>
                            <tr>
                                <th scope="row">API Key</th>
                                <td><?= $config['payment']['apikey']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Private Key</th>
                                <td><?= $config['payment']['apiprivatekey']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Merchant</th>
                                <td><?= $merchant; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Kode Merchant</th>
                                <td><?= $config['payment']['kodemerchant']; ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mb-3 mt-3">
                            <div class="mb-3 mt-3">
                                <button type="button" class="btnhilang mb-1" data-toggle="modal"
                                        data-target="#paymentModal">
                                    <span class="iconify mb-3" data-icon="bxs:edit" data-inline="false"
                                          style="color: green;" data-width="30" data-height="30"></span>
                                </button>
                            </div>
                        </div>
                        <hr style="border-top: 2px dashed green;">
                    </div>
                    <div class="mb-3">
                        <table class="table table-striped">
                            <div class="mb-3">
                                <h3>Penghasilan</h3>
                            </div>
                            <tbody>
                            <tr>
                                <th scope="row">Fee Transaksi</th>
                                <td><?= $config['feemc']['percent']; ?>%</td>
                            </tr>
                            <tr>
                                <th scope="row">Minimal Pencairan</th>
                                <td><?= $config['cair']['minimal']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Fee Pencairan</th>
                                <td><?= $config['cair']['fee']; ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mb-3 mt-3">
                            <div class="mb-3 mt-3">
                                <button type="button" class="btnhilang mb-1" data-toggle="modal"
                                        data-target="#penghasilanModal">
                                    <span class="iconify mb-3" data-icon="bxs:edit" data-inline="false"
                                          style="color: green;" data-width="30" data-height="30"></span>
                                </button>
                            </div>
                        </div>
                        <hr style="border-top: 2px dashed green;">
                    </div>
                </center>
            </div>
        </div>
    </div>

    <div class="modal fade" id="gauthModal" tabindex="-1" aria-labelledby="gauthModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gauthModalLabel">Edit Gauth</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/setting/gauth'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="form-group row">
                            <label for="id" class="col-sm-3 col-form-label">ID</label>
                            <div class="col-sm-9">
                            <input type="text" class="form-control" id="id" aria-describedby="idhelp" placeholder="ID" name="id" value="<?= $config['gauth']['id']; ?>">
                                <small id="idhelp" class="form-tex" style="color:red;"><?= $validation->getError('id'); ?></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="secret" class="col-sm-3 col-form-label">Secret</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="secret" aria-describedby="secrethelp" placeholder="Secret Key" name="secret" value="<?= $config['gauth']['secret']; ?>">
                                <small id="secrethelp" class="form-tex" style="color:red;"><?= $validation->getError('secret'); ?></small>
                            </div>
                        </div>
                        <center>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Edit Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/setting/payment'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="form-group row">
                            <label for="id" class="col-sm-3 col-form-label">ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="id" aria-describedby="idhelp" placeholder="ID" name="id" value="<?= $config['gauth']['id']; ?>">
                                <small id="idhelp" class="form-tex" style="color:red;"><?= $validation->getError('id'); ?></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="secret" class="col-sm-3 col-form-label">Secret</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="secret" aria-describedby="secrethelp" placeholder="Secret Key" name="secret" value="<?= $config['gauth']['secret']; ?>">
                                <small id="secrethelp" class="form-tex" style="color:red;"><?= $validation->getError('secret'); ?></small>
                            </div>
                        </div>
                        <center>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="penghasilanModal" tabindex="-1" aria-labelledby="penghasilanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penghasilanModalLabel">Edit Penghasilan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/setting/penghasilan'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="form-group row">
                            <label for="feemc" class="col-sm-5 col-form-label">Fee Transaksi</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="feemc" aria-describedby="feemchelp" placeholder="ID" name="feemc" value="<?= $config['feemc']['percent']; ?>">
                                <small id="feemchelp" class="form-tex" style="color:red;"><?= $validation->getError('id'); ?></small>
                            </div>
                            <label class="col-sm-1 col-form-label">%</label>
                        </div>
                        <div class="form-group row">
                            <label for="minimal" class="col-sm-5 col-form-label">Minimal Pencairan</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="minimal" aria-describedby="minimalhelp" placeholder="Secret Key" name="minimal" value="<?= $config['cair']['minimal']; ?>">
                                <small id="minimalhelp" class="form-tex" style="color:red;"><?= $validation->getError('minimal'); ?></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fee" class="col-sm-5 col-form-label">Fee Pencairan</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="fee" aria-describedby="feehelp" placeholder="Secret Key" name="fee" value="<?= $config['cair']['fee']; ?>">
                                <small id="feehelp" class="form-tex" style="color:red;"><?= $validation->getError('fee'); ?></small>
                            </div>
                        </div>
                        <center>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
<?= $this->endSection(); ?>