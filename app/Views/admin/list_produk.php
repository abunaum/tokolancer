<?= $this->extend('mypanel/template'); ?>
<?= $this->section('head'); ?>
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap4.min.css" rel="stylesheet" media="all">
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
    <!-- Begin Page Content -->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
            <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
            <div class="container-fluid">

                <!-- Page Heading -->
                <center>
                    <div class="mb-3">
                        <h1>List Produk</h1>
                        <hr style="border-top: 2px dashed green;">
                    </div>
                    <div style="overflow-x:auto;">
                        <table id="produk" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <td>#</td>
                            <td>Nama</td>
                            <td>Harga</td>
                            <td>Kategori</td>
                            <td>Jenis</td>
                            <td>Toko</td>
                            <td>Aksi</td>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($produk as $p) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= $p['nama']; ?></td>
                                    <td><?= number_to_currency($p['harga'], 'IDR', 'id_ID',0); ?></td>
                                    <td><?= $p['nama_item']; ?></td>
                                    <td><?= $p['nama_subitem']; ?></td>
                                    <td>@<?= $p['username']; ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-6">
                                                <form action="<?= base_url('admin/toko/hapusproduk') . '/' . $p['id'] ?>"
                                                      method="post">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="button" class="btn btn-danger delete-one"
                                                            style="width: 100%;" data-nama="<?= $p['nama'] ?>">Hapus
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-6">
                                                    <a class="btn btn-success" style="width: 100%;" href="<?= base_url('/produk/detail'.'/'.$p['id']) ;?>" target="_blank">Detail</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                </center>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#produk').DataTable( {
                fixedHeader: true
            });
        });
        $(".delete-one").on('click', function(e) {
            var nama = $(this).data('nama');
            Swal.fire({
                title: 'Anda yakin?',
                text: 'Mau menghapus ' + nama + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.submit();
                }
            })
        })
    </script>
<?= $this->endSection(); ?>