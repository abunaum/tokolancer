<?= $this->extend('mypanel/template'); ?>
<?= $this->section('head'); ?>
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" rel="stylesheet" media="all">
<link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css" rel="stylesheet" media="all">
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
                    <h1>Transaksi Bermasalah</h1>
                    <hr style="border-top: 2px dashed green;">
                </div>
                <div style="overflow-x:auto;">
                    <table id="transaksi" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                        <td>#</td>
                        <td>Tanggal</td>
                        <td>Invoice</td>
                        <td>Buyer</td>
                        <td>Toko</td>
                        <td>Produk</td>
                        <td>Jumlah</td>
                        <td></td>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($transaksi as $t) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= tgl_indo($t['updated_at']); ?></td>
                                <td><?= $t['invoice']; ?></td>
                                <td><?= $t['email_buyer']; ?></td>
                                <td>@<?= $t['nama_toko']; ?></td>
                                <td><a href="<?= base_url('produk/detail').'/'.$t['id_produk'];?>" target="_blank"><?= $t['nama_produk']; ?></a></td>
                                <td><?= $t['jumlah']; ?></td>
                                <td>
                                    <?php $id = $t['id'] ;?>
                                    <?php $data = $t['invoice'] ;?>
                                    <div class="row">
                                        <div class="col-6">
                                            <form action="<?= base_url('admin/transaksi/refund') . '/' . $t['id'] ?>" method="post" id="refund-<?= $t['id'] ;?>">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btn btn-danger" style="width: 100%;" onclick="refund('<?= $id;?>','<?= $data;?>')">Refund
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-6">
                                            <form action="<?= base_url('admin/transaksi/konfirmasi') . '/' . $t['id'] ?>" method="post" id="confirm-<?= $t['id'] ;?>">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btn btn-success"
                                                        style="width: 100%;" onclick="confirm('<?= $id;?>','<?= $data;?>')">Lepas
                                                </button>
                                            </form>
                                        </div>
                                    </div>
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
<script>
    function refund(id,data){
        formnya = document.getElementById('refund-'+id);
        nama = data;
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Mau merefund transaksi ' + nama + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                formnya.submit();
            }
        })
    }
    function confirm(id,data){
        formnya = document.getElementById('confirm-'+id);
        nama = data;
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Mau melepas transaksi ' + nama + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                formnya.submit();
            }
        })
    }
</script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#transaksi').DataTable( {
            fixedHeader: true
        });
    });
</script>
<?= $this->endSection(); ?>
