<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <!-- <center> -->
        <?php $trxup = array_column($transaksi, 'UNPAID'); ?>
        <?php if ($trxup) : ?>
            <h1>Ready to pay : </h1>
            <?php foreach ($trxup[0] as $trxup) : ?>
                <table class="shop_table shop_table_responsive cart">
                    <thead>
                        <tr>
                            <th class="product-remove">&nbsp;</th>
                            <th class="product-thumbnail">&nbsp;</th>
                            <th class="product-name">Jenis</th>
                            <th class="product-name">Order Number</th>
                            <th class="product-price">Nominal</th>
                            <th class="product-price">Metode Pembayaran</th>
                            <th class="product-quantity">Fee</th>
                            <th class="product-subtotal">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="product-remove">
                                <a class="remove" href="#">×</a>
                            </td>
                            <td class="product-thumbnail">
                                <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url(); ?>/logotoko.png">
                            </td>
                            <td data-title="Product" class="product-name">
                                <div class="media cart-item-product-detail">
                                    <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url(); ?>/logotoko.png">
                                    <div class="media-body align-self-center">
                                        <a href="<?= base_url('user/saldo') ?>"><?= $trxup['jenis'] ?></a>
                                    </div>
                                </div>
                            </td>
                            <td data-title="Order Number" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol"><i><?= $trxup['order_number'] ?></i></span>
                                </span>
                            </td>
                            <td data-title="Nominal" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($trxup['nominal']) ?>
                                </span>
                            </td>
                            <td data-title="Metode Pembayaran" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol"><?= $trxup['metode'] ?>
                                    </span>
                            </td>
                            <td data-title="Fee" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($trxup['fee']) ?>
                                </span>
                            </td>
                            <td data-title="Total" class="product-subtotal">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp</span><?= number_format($trxup['nominal'] + $trxup['fee']) ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-6">
                        <form action="<?= base_url('user/transaksisaldo/hapus') . '/' . $trxup['id'] ?>" method="post" id="hapustransaksi">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" class="btn btn-danger tmbl-hps" style="width: 100%;" data-nama="<?= $trxup['order_number'] ?>">Hapus</button>
                        </form>
                    </div>
                    <div class="col-6">
                        <form method="post" action="<?= base_url('user/topup/prosess') . '/' . $trxup['id'] ?>">
                            <button type="submit" class="btn btn-success" style="width: 100%;">Bayar</button>
                    </div>
                    </form>
                </div>
                <!-- .shop_table shop_table_responsive -->
                <hr style="border-top: 2px dashed green;">
            <?php endforeach; ?>
        <?php endif; ?>
        <?php $trxexp = array_column($transaksi, 'EXPIRED'); ?>
        <?php if ($trxexp) : ?>
            <hr style="border-top: 2px dashed red;" class="mt-3">
            <h1>Expired : </h1>
            <?php foreach ($trxexp[0] as $trxexp) : ?>
                <table class="shop_table shop_table_responsive cart">
                    <thead>
                        <tr>
                            <th class="product-remove">&nbsp;</th>
                            <th class="product-thumbnail">&nbsp;</th>
                            <th class="product-name">Jenis</th>
                            <th class="product-name">Order Number</th>
                            <th class="product-price">Nominal</th>
                            <th class="product-price">Metode Pembayaran</th>
                            <th class="product-quantity">Fee</th>
                            <th class="product-subtotal">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="product-remove">
                                <a class="remove" href="#">×</a>
                            </td>
                            <td class="product-thumbnail">
                                <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url(); ?>/logotoko.png">
                            </td>
                            <td data-title="Product" class="product-name">
                                <div class="media cart-item-product-detail">
                                    <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url(); ?>/logotoko.png">
                                    <div class="media-body align-self-center">
                                        <a href="<?= base_url('user/saldo') ?>"><?= $trxexp['jenis'] ?></a>
                                    </div>
                                </div>
                            </td>
                            <td data-title="Order Number" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol"><i><?= $trxexp['order_number'] ?></i></span>
                                </span>
                            </td>
                            <td data-title="Nominal" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($trxexp['nominal']) ?>
                                </span>
                            </td>
                            <td data-title="Metode Pembayaran" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol"><?= $trxexp['metode'] ?>
                                    </span>
                            </td>
                            <td data-title="Fee" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($trxexp['fee']) ?>
                                </span>
                            </td>
                            <td data-title="Total" class="product-subtotal">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp</span><?= number_format($trxexp['nominal'] + $trxexp['fee']) ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-6">
                        <form action="<?= base_url('user/transaksisaldo/hapus') . '/' . $trxexp['id'] ?>" method="post" id="hapustransaksi">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" class="btn btn-danger tmbl-hps" style="width: 100%;" data-nama="<?= $trxexp['order_number'] ?>">Hapus</button>
                        </form>
                    </div>
                    <div class="col-6">
                        <form method="post" action="<?= base_url('user/topup/ulangprosess') . '/' . $trxexp['id'] ?>">
                            <button type="submit" class="btn btn-success" style="width: 100%;">Perbarui</button>
                    </div>
                    </form>
                </div>
                <!-- .shop_table shop_table_responsive -->
                <hr style="border-top: 2px dashed green;">
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- .cart-collaterals -->
        <!-- </center> -->
    </div>
    <!-- .col-full -->
</section>
</div>
<?= $this->endSection(); ?>