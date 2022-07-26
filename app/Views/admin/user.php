<?= $this->extend('mypanel/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

            <!-- Page Heading -->
            <center>
                <h1>Daftar User</h1>
                <div style="overflow-x:auto;">
                    <table class="table table-striped">
                        <thead>
                            <td>#</td>
                            <td>Username</td>
                            <td>Toko</td>
                            <td>Saldo</td>
                            <td>Status</td>
                            <td>
                                Aksi
                            </td>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($user as $user) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= $user['email']; ?></td>
                                    <td>
                                        <?php
                                        if($user['status_toko'] == 4){
                                           echo 'Active';
                                        } else {
                                            echo 'Non-active';
                                        }
                                        ?>
                                    </td>
                                    <td>Rp.<?= number_format($user['balance']); ?></td>
                                    <td><?= $user['status'] == 1 ? 'Aktif':'Banned'; ?></td>
                                    <td>
                                        <?php if ($user['status'] == 1): ?>
                                            <form action="<?= base_url('admin/user/disable') . '/' . $user['id']; ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btnhilang ban-usr" data-nama="<?= $user['email']; ?>">
                                                    <span class="iconify" data-icon="fe:disabled" style="color: red;" data-inline="false" data-width="24" data-height="24"></span>
                                                </button>
                                            </form>
                                        <?php else : ?>
                                            <form action="<?= base_url('admin/user/enable') . '/' . $user['id']; ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btnhilang unban-usr" data-nama="<?= $user['email']; ?>">
                                                    <span class="iconify" data-icon="icon-park-outline:correct" style="color: green;" data-inline="false" data-width="24" data-height="24"></span>
                                                </button>
                                            </form>
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 mb-3">
                    <?= $pager->links('user','halaman'); ?>
                </div>
            </center>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(".ban-usr").on('click', function(e) {
        var nama = $(this).data('nama');
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Mau membanned ' + nama + ' ?',
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
    $(".unban-usr").on('click', function(e) {
        var nama = $(this).data('nama');
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Mau melepas banned ' + nama + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lepas',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.form.submit();
            }
        })
    })
</script>
<?= $this->endSection(); ?>