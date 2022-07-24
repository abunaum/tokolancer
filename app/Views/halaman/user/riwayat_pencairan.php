<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <center>
            <?php if (count($pencairan) >= 1):; ?>
                <div class="mb-3 mt-3">
                    <h1>Riwayat Pencairan Dana</h1>
                </div>
                <hr style="border-top: 2px dashed green;">
                <?php foreach ($pencairan as $p) : ?>
                    <table class="shop_table shop_table_responsive cart">
                        <thead>
                        <tr>
                            <th class="product-name">Nominal</th>
                            <th class="product-name">Fee</th>
                            <th class="product-price">Tgl Request</th>
                            <th class="product-price">Tgl Konfirmasi</th>
                            <th class="product-price">Status</th>
                            <th class="product-quantity">Keterangan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td data-title="Order Number" class="product-price">
                    <span class="woocommerce-Price-amount amount">
                        <span>
                            <i><?= number_to_currency($p['nominal'], 'IDR', 'id_ID', 0); ?></i>
                        </span>
                    </span>
                            </td>
                            <td data-title="Nominal" class="product-price">
                    <span class="woocommerce-Price-amount amount">
                        <span>
                            <i><?= number_to_currency($p['fee'], 'IDR', 'id_ID', 0); ?></i>
                        </span>
                    </span>
                            </td>
                            <td data-title="Jumlah Pesanan" class="product-price">
                    <span>
                        <?= tgl_indo($p['created_at']); ?>
                    </span>
                            </td>
                            <td data-title="Jumlah Pesanan" class="product-price">
                    <span>
                        <?= tgl_indo($p['updated_at']); ?>
                    </span>
                            </td>
                            <td data-title="Status">
                    <span>
                        <?= $p['status'] == 2 ? 'Sukses' : 'Ditolak';?>
                    </span>
                            </td>
                            <td data-title="Status">
                    <span>
                        <?= $p['keterangan'] ?>
                    </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr style="border-top: 1px dashed black;">
                <?php endforeach; ?>
            <?php endif; ?>
        </center>
    </div>
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>
