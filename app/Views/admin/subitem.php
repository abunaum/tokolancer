<?= $this->extend('mypanel/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <button type="button" class="btnhilang mb-1" data-toggle="modal" data-target="#subModal">
                <span class="iconify mb-3" data-icon="carbon:add-filled" data-inline="false" style="color: green;" data-width="30" data-height="30"></span>
            </button>
            <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
            <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
            <center>
                <div style="overflow-x:auto;">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Item</th>
                                <th scope="col">Status</th>
                                <th scope="col">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php foreach ($subitem as $sub) : ?>
                                <?php $i++ ?>
                                <tr>
                                    <th scope="row"><?= $i ?></th>
                                    <td><?= $sub['nama']; ?></td>
                                    <?php
                                    $db = \Config\Database::connect();
                                    $builder = $db->table('item');
                                    $builder->where('id', $sub['item']);
                                    $item = $builder->get()->getFirstRow();
                                    ?>
                                    <td><?= $item->nama; ?></td>
                                    <?php if ($sub['status'] == 0) : ?>
                                        <form action="<?= base_url('admin/subitem/aktifkan') . '/' . $sub['id'] ?>" method="post">
                                            <?= csrf_field() ?>
                                            <td>
                                                <button type="submit" class="btnhilang">
                                                    <span class="iconify" data-icon="fe:disabled" data-inline="false" style="color: red;" data-width="24" data-height="24"></span>
                                                </button>
                                            </td>
                                        </form>
                                    <?php else : ?>
                                        <form action="<?= base_url('admin/subitem/nonaktifkan') . '/' . $sub['id'] ?>" method="post">
                                            <?= csrf_field() ?>
                                            <td>
                                                <button type="submit" class="btnhilang">
                                                    <span class="iconify" data-icon="bx:bx-check-circle" data-inline="false" style="color: green;" data-width="24" data-height="24"></span>
                                                </button>
                                            </td>
                                        </form>
                                    <?php endif; ?>
                                    <form action="<?= base_url('admin/subitem/hapus') . '/' . $sub['id'] ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <td>
                                            <button type="button" class="btnhilang tmbl-hps" data-nama="<?= $sub['nama'] ?>">
                                                <span class="iconify" data-icon="ic:baseline-delete-forever" data-inline="false" style="color: red;" data-width="24" data-height="24"></span>
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="mb-3 mt-3">
                        <?= $pager->links('subitem','halaman'); ?>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="subModal" tabindex="-1" aria-labelledby="subModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subModalLabel">Tambah Sub Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <form class="g-3 needs-validation" action="<?= base_url('admin/subitem/add_item'); ?>" method="post" novalidate>
                        <?= csrf_field(); ?>
                        <div class="mt-4">
                            <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" id="nama" name="nama" placeholder="Nama Item" autofocus>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Item">Item</label>
                            <select class="form-control" aria-label="Default select example" id="item" name="item">
                                <?php foreach ($itemlist as $it) : ?>
                                    <option value="<?= $it['id']; ?>"><?= $it['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status">Status Sub Item</label>
                            <select class="form-control" aria-label="Default select example" id="sub" name="sub">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
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
<!-- /.container-fluid -->
<?= $this->endSection(); ?>