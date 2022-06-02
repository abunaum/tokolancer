<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full d-flex justify-content-center mt-3">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah Produk</strong>
                </div>
                <div class="card-body card-block">
                    <form action="<?= base_url('user/toko/tambahproduk'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal needs-validation">
                        <?= csrf_field(); ?>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="item" class="form-control-label">Item</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select onchange="pilihitem()" id="item" name="item" class="form-control <?= ($validation->hasError('item')) ? 'is-invalid' : ''; ?>">
                                    <option value="">-- Pilih Item --</option>
                                    <?php foreach ($item as $ip) : ?>
                                        <option value="<?= $ip['namaitem']; ?>"><?= $ip['namaitem']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="help-block form-text">
                                    <?= $validation->getError('item'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="row form-group" id="subdiv" style="display: none">
                            <div class="col col-md-3">
                                <label for="sub" class="form-control-label">Subitem</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="sub" id="sub" class="form-control  <?= ($validation->hasError('sub')) ? 'is-invalid' : ''; ?>">
                                    <option value="">-- Pilih Subitem --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="nama" class=" form-control-label">Nama Produk</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="nama" name="nama" placeholder="Nama Produk" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" value="<?= old('nama'); ?>">
                                <small class="help-block form-text">
                                    <?= $validation->getError('nama'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="harga" class=" form-control-label">Harga</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="number" id="harga" name="harga" placeholder="Harga" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : ''; ?>" value="<?= old('harga'); ?>">
                                <small class="help-block form-text">
                                    <?= $validation->getError('harga'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="deskripsi" class=" form-control-label">Deskripsi</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea name="deskripsi" id="deskripsi" rows="9" placeholder="Deskripsi Produk" class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : ''; ?>"><?= old('deskripsi'); ?></textarea>
                                <small class="help-block form-text">
                                    <?= $validation->getError('deskripsi'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="gambar" class=" form-control-label">Gambar</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" class="form-control  <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" class="form-control-file">
                                <small class="help-block form-text">
                                    <?= $validation->getError('gambar'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="stok" class=" form-control-label">Stok</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="number" id="stok" name="stok" placeholder="Stok" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : ''; ?>" value="<?= old('stok'); ?>">
                                <small class="help-block form-text">
                                    <?= $validation->getError('stok'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-dot-circle-o"></i> Tambah
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3">
                <center>
                    <h1>Punya Produk Baru ?</h1>
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#baruModal">
                        Ajukan Produk Baru Sekarang
                    </button>
                </center>
            </div>
        </div>
    </div>
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    function pilihitem() {
        var item = <?= json_encode($item); ?>;

        var item_val = document.getElementById("item").value;
        var sub = document.getElementById('subdiv');
        const id = document.getElementById("item").value;
        if (item_val != '') {
            sub.style.display = '';
            var html = '<option value = "">-- Pilih Sub --</option>';
            for (ji in item) {
                var sub = item[ji][item_val];
                for (si in sub) {
                    var nama = sub[si].nama;
                    var idsub = sub[si].id;
                    html += '<option value=' + idsub + '>' + nama + '</option>';
                }
            }
            document.getElementById("sub").innerHTML = html;
        } else {
            sub.style.display = 'none';
        }
    }
</script>
<?= $this->endSection(); ?>