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
                        <h1>Riwayat Pencairan</h1>
                        <hr style="border-top: 2px dashed green;">
                    </div>
                    <div style="overflow-x:auto;">
                        <table id="pencairan" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                            <td>#</td>
                            <td>Tanggal</td>
                            <td>Email</td>
                            <td>Metode</td>
                            <td>Nomor Rekening</td>
                            <td>Nama</td>
                            <td>Nominal</td>
                            <td>Status</td>
                            <td>Keterangan</td>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($pencairan as $p) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= tgl_indo($p['updated_at']); ?></td>
                                    <td><?= $p['email']; ?></td>
                                    <td><?= $p['metode']; ?></td>
                                    <td><?= $p['no_rek']; ?></td>
                                    <td><?= $p['nama_rek']; ?></td>
                                    <td><?= number_to_currency($p['nominal'],'IDR','id_ID',0); ?></td>
                                    <td><?= $p['status'] == 2 ? 'Sukses' : 'Ditolak'; ?></td>
                                    <td><?= $p['keterangan']; ?></td>
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
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#pencairan').DataTable( {
            fixedHeader: true
        });
    });
    $(".delete-one").on('click', function(e) {
        var nama = $(this).data('nama');
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Mau menghapus ' + nama + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.form.submit();
            }
        })
    })
</script>
<?= $this->endSection(); ?>
