<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="<?= base_url('admin'); ?>">
            <img src="<?= base_url(); ?>/logotoko.png" style="width: 100%; height: auto;" alt="Abunaum" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <?= $this->include('mypanel/menu') ?>
            </ul>
        </nav>
    </div>
</aside>