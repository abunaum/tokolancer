<li>
    <a href="<?= base_url('admin'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i></i>Dashboard</a>
</li>
<li class="has-sub">
    <a class="js-arrow" href="#">
        <i class="fas fa-fw fa-sitemap"></i>Item</a>
    <ul class="list-unstyled navbar-mobile-sub__list js-sub-list">
        <li>
            <a href="<?= base_url('admin/item'); ?>">Item</a>
        </li>
        <li>
            <a href="<?= base_url('admin/subitem'); ?>">Sub Item</a>
        </li>
    </ul>
</li>
<li class="has-sub">
    <a class="js-arrow" href="#">
        <i class="fas fa-fw fa-users"></i>User</a>
    <ul class="list-unstyled navbar-mobile-sub__list js-sub-list">
        <li>
            <a href="<?= base_url('admin/user'); ?>">Daftar User</a>
        </li>
    </ul>
</li>
<li class="has-sub">
    <a class="js-arrow" href="#">
        <i class="fas fa-fw fa-store"></i>Toko</a>
    <ul class="list-unstyled navbar-mobile-sub__list js-sub-list">
        <li>
            <a href="<?= base_url('admin/toko/pengajuan'); ?>">Pengajuan Toko</a>
        </li>
    </ul>
</li>
<?php
$date = date('d F Y h:i:s a');
echo $date;
?>