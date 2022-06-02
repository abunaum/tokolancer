<center>
    <div class="card w-75">
        <div class="card-body">
            <div class="dropdown-list-image mr-3">
                <img class="rounded-circle" src="<?= base_url('/img/toko') . '/' . $toko[0]['logo'] ?>" alt="logo">
                <div class="status-indicator bg-success"></div>
            </div>
            <h2><?= $toko[0]['username'] ?></h2>
            <div>
                <i>"<?= $toko[0]['selogan'] ?>"</i>
            </div>
            Toko anda sedang dalam proses peninjauan, harap menunggu toko anda di aktivasi.
            <br>
            Silahkan aktifkan fitur <a href="<?= base_url('user/notifikasi') ?>" style="color:#1e7e34;">notifikasi Telegram</a> agar anda menerima notifikasi saat toko anda sudah di aktivasi.
        </div>
    </div>
</center>