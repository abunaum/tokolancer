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
                    <h1>List Toko</h1>
                    </div>
                    <div style="overflow-x:auto;">
                        <table id="toko" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <td>#</td>
                            <td>Email</td>
                            <td>Username</td>
                            <td>Status</td>
                            <td>Saldo</td>
                            <td>Produk</td>
                            <td>Aksi</td>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($toko as $t) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= $t['user']['email']; ?></td>
                                    <td>@<?= $t['toko']['username']; ?></td>
                                    <td>
                                        <?php
                                        if ($t['user']['status_toko']== 1){
                                            echo 'Pending';
                                        } elseif ($t['user']['status_toko']== 2){
                                            echo 'Verifikasi';
                                        } elseif ($t['user']['status_toko']== 3){
                                            echo 'Ditolak';
                                        } elseif ($t['user']['status_toko']== 4){
                                            echo 'Aktif';
                                        } elseif ($t['user']['status_toko']== 5){
                                            echo 'Banned';
                                        }
                                        ?>
                                    </td>
                                    <td><?= number_to_currency($t['user']['balance'], 'IDR', 'id_ID',0); ?></td>
                                    <td><?= count($t['produk']); ?></td>
                                    <td>
                                        <?php if ($t['user']['status_toko']== 4):?>
                                            <form action="<?= base_url('admin/toko/banned') . '/' . $t['toko']['id'] ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btn btn-danger banned-one" style="width: 100%;" data-nama="<?= $t['toko']['username'] ?>">Banned
                                                </button>
                                            </form>
                                        <?php elseif ($t['user']['status_toko']== 5):?>
                                            <form action="<?= base_url('admin/toko/unbanned') . '/' . $t['toko']['id'] ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btn btn-success unbanned-one" style="width: 100%;" data-nama="<?= $t['toko']['username'] ?>">Unbanned
                                                </button>
                                            </form>

                                        <?php endif;?>
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
        var table = $('#toko').DataTable( {
            fixedHeader: true
        });
    });
    $(".banned-one").on('click', function(e) {
        var nama = $(this).data('nama');
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Mau membanned Toko @' + nama + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Banned',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.form.submit();
            }
        })
    })
    $(".unbanned-one").on('click', function(e) {
        var nama = $(this).data('nama');
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Mau membuka banned Toko @' + nama + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lepaskan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.form.submit();
            }
        })
    })
</script>
<?= $this->endSection(); ?>