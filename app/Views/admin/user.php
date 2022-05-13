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
                            <td>
                                <center>Detail</center>
                            </td>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($user as $user) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <?php
//                                    $db = \Config\Database::connect();
//                                    $grup = $db->table('auth_groups_users');
//                                    $grup->where('user_id', $user->id);
//                                    $grup = $grup->get()->getFirstRow();
//                                    $grupid = $grup->group_id;
//                                    $carigrup = $db->table('auth_groups');
//                                    $carigrup->where('id', $grupid);
//                                    $carigrup = $carigrup->get()->getFirstRow();
//                                    $namagrup = $carigrup->name;
                                    ?>
                                    <td><?= $user['email']; ?></td>
                                    <td>xxx</td>
                                    <td>Rp.<?= number_format($user['balance']); ?></td>
                                    <td>
                                        <div class="row">
                                            <form class="col-2" action="<?= base_url('admin/user') . '/' . $user['id']; ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btnhilang">
                                                    <span class="iconify" data-icon="mdi:card-account-details-outline" data-inline="false" style="color: darkgreen;" data-width="24" data-height="24"></span>
                                                </button>
                                            </form>
                                            <form class="col-2"
                                                  action="<?= base_url('admin/user') . '/' . $user['id']; ?>"
                                                  method="post">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btnhilang tmbl-hps"
                                                        data-nama="<?= $user['fullname']; ?>">
                                                    <span class="iconify" data-icon="ic:baseline-delete-forever"
                                                          data-inline="false" style="color: red;" data-width="24"
                                                          data-height="24"></span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?= $pager->links(); ?>
            </center>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>