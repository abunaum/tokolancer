<nav id="navbar-primary" class="navbar-primary" aria-label="Navbar Primary" data-nav="flex-menu">
    <ul id="menu-navbar-primary" class="nav yamm">
        <?php foreach ($item as $i) : ?>
                <li class="menu-item menu-item-has-children animate-dropdown dropdown">
                    <a title="<?= $i['namaitem']; ?>" data-toggle="dropdown" class="dropdown-toggle" href="#"><?= $i['namaitem']; ?>
                        <span class="caret"></span>
                    </a>
                    <ul role="menu" class="dropdown-menu">
                    <?php $nama = $i['namaitem']; ?>
                    <?php foreach ($i[$nama] as $s) : ?>
                            <li class="menu-item animate-dropdown">
                                <a title="<?= $s['nama']; ?>" href="<?= base_url('jenis').'/'.$s['id']; ?>"><?= $s['nama']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
        <?php endforeach; ?>
        <li class="techmarket-flex-more-menu-item dropdown">
            <a title="..." href="#" data-toggle="dropdown" class="dropdown-toggle">...</a>
            <ul class="overflow-items dropdown-menu"></ul>
        </li>
    </ul>
</nav>