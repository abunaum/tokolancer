<?= $this->extend('paytemplate/pay'); ?>
<?= $this->section('content'); ?>
<img src="https://payment.tripay.co.id/images/grass.jpg" id="bg" alt="">
<div class="container pt-4 pb-4">
    <div class="row">
        <div class="col-lg-8 col-12 mx-auto">

            <div class="box-shape pl-lg-5 pr-lg-5 pt-lg-4 pb-lg-4 p-3">

                <div class="payment__logo float-left">
                    <img src="<?= base_url(); ?>/logotoko.png" style="height: 30px;width: auto;">
                </div>

                <div class="payment__title">
                    <h5>Pembayaran dengan <b><?= $transaksi['payment_name']; ?></b></h5>
                    Pastikan anda melakukan pembayaran sebelum melewati batas
                    <br>
                    pembayaran dan dengan nominal yang tepat
                </div>

                <div class="row">
                    <div class="col-lg-7">
                        <div class="mb-3">
                            <div class="payment__infoTitle">
                                Nama Pelanggan
                            </div>
                            <div class="payment__infoSubtitle">
                                <?= $transaksi['customer_name']; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="payment__infoTitle">
                                Email Pelanggan
                            </div>
                            <div class="payment__infoSubtitle">
                                <?= $transaksi['customer_email']; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="payment__infoTitle">
                                Order Number
                            </div>
                            <div class="payment__infoSubtitle">
                                <?= $transaksi['merchant_ref']; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="payment__infoTitle">
                                Rincian Transaksi
                            </div>
                            <div class="payment__infoSubtitle">
                                <div class="row mb-1">
                                    <div class="col-8">
                                        <?= $transaksi['order_items'][0]['name'] . ' (x' . $transaksi['order_items'][0]['quantity'] . ')'; ?>
                                        <br />
                                        <small class="ml-3">@ Rp. <?= number_format($transaksi['order_items'][0]['price']); ?></small>
                                    </div>
                                    <div class="col-4 text-right">
                                        Rp. <?= number_format($transaksi['order_items'][0]['subtotal']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 payment-info" style="height: fit-content;">
                        <div class="mb-3">
                            <div class="payment__infoTitle">
                                Nomor Referensi
                            </div>
                            <div class="payment__infoSubtitle">
                                <div class="input-group pt-1">
                                    <input type="text" class="form-control border-right-0" id="noReferensi" i data-toggle="tooltip" title="Berhasil menyalin teks" value="<?= $transaksi['reference']; ?>" aria-describedby="inputGroupPrepend" readonly style="background: #fff">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-left-0">
                                            <i class="zmdi zmdi-copy zmdi-hc-lg icon-copy" data-toggle="tooltip" data-placement="top" title="Salin" onclick="copy('noReferensi')"></i>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="payment__infoTitle">
                                Kode Bayar/Nomor VA
                            </div>
                            <div class="payment__infoSubtitle">
                                <div class="input-group pt-1">
                                    <input type="text" class="form-control border-right-0" id="noVA" i data-toggle="tooltip" title="Berhasil menyalin teks" value="<?= $transaksi['pay_code']; ?>" aria-describedby="inputGroupPrepend" readonly style="background: #fff">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-left-0">
                                            <i class="zmdi zmdi-copy zmdi-hc-lg icon-copy" data-toggle="tooltip" data-placement="top" title="Salin" onclick="copy('noVA')"></i>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="payment__infoTitle">
                                Jumlah Tagihan
                            </div>
                            <div class="payment__infoSubtitle">
                                <div class="input-group pt-1">
                                    <input type="text" class="form-control border-right-0" id="jumTagihan" value="Rp <?= number_format($transaksi['order_items'][0]['subtotal']); ?>" aria-describedby="inputGroupPrepend" readonly style="background: #fff">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-left-0">
                                            <i class="zmdi zmdi-copy zmdi-hc-lg icon-copy" data-toggle="tooltip" data-placement="top" title="Salin" onclick="copy('jumTagihan')"></i>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="payment__infoTitle">
                                Batas Pembayaran
                            </div>
                            <div class="payment__expired">
                                <?= date('d F Y h:i', $transaksi['expired_time']); ?> WIB
                            </div>
                        </div>
                        <?php if ($transaksi['payment_name'] == 'QRIS') : ?>
                            <div class="mb-3">
                                <div class="payment__infoSubtitle">
                                    <small style="font-style: italic;">* Klik untuk memperbesar kode QR</small>
                                    <a class="fancybox" href="<?= $transaksi['qr_url']; ?>">
                                        <img src="<?= $transaksi['qr_url']; ?>" style="width:100%;max-width:170px !important;cursor:zoom-in" />
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="ml-auto pb-2 mt-4">
                        <a href="<?= base_url('user/saldo/topup'); ?>" class="btn btn-info waves-effect waves-light" type="button">Kembali ke Merchant <span id="auto-redirect"></span></a>
                        <button type="button" class="btn btn btn-success button-green" id="payment_instruction_button" data-bs-toggle="modal" data-bs-target="#cara_bayar">Cara Pembayaran</button>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="m-auto pb-2" style="margin-top: 55px !important;font-size: 14px;">
                        Secure Payment by <a href="https://payment.tripay.co.id" target="_blank"><img src="https://tripay.co.id/assets/images/logo-dark.png" style="height:20px;margin-left: 7px;" alt="TriPay"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cara_bayar" tabindex="-1" aria-labelledby="cara_bayarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="cara_bayar_title">
                    <div class="d-flex flex-row">
                        <div class="ml-3 title-pembayaran">
                            Petunjuk Pembayaran <?= $transaksi['payment_name']; ?>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 pr-0 pl-0 mt-0">
                <div id="payment-modal" class="custom-accordion">
                    <div class="card custom-padding-accordion">
                        <?php foreach ($transaksi['instructions'] as $pembayaran) : ?>
                            <div class="card-header payment-instruction-head" id="payment-instruction-head-0">
                                <h5 class="mb-0">
                                    <span class="btn collaped panel-title" data-bs-toggle="collapse" data-bs-target="#payment-instruction-collapse-0" aria-expanded="true" aria-controls="payment-instruction-collapse-0">Pembayaran via <?= $pembayaran['title']; ?></span>
                                </h5>
                            </div>
                            <div id="payment-instruction-collapse-0" class="collapse show custom-padding-accordion-2" aria-labelledby="payment-instruction-head-0" data-parent="#payment-modal">
                                <div class="card-body">
                                    <ol class="list-petunjuk-pembayaran">
                                        <?php foreach ($pembayaran['steps'] as $intruksi) : ?>
                                            <li><?= $intruksi; ?></li>
                                        <?php endforeach; ?>
                                    </ol>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>