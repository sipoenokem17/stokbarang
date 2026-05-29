<!-- CONTENT HEADER -->
<div class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6">
                <h1 class="m-0">
                    Data Barang Masuk
                </h1>
            </div>

            <div class="col-sm-6 text-right">
                <a href="index.php?page=formMasuk"
                    class="btn btn-success">

                    <i class="fas fa-plus mr-1"></i>
                    Tambah Barang Masuk

                </a>
            </div>

        </div>

    </div>
</div>


<!-- CONTENT -->
<section class="content">
    <div class="container-fluid">
        <?php
        include "sambungkan.php";
        // TOTAL QTY HARI INI
        $today = date('Y-m-d');
        $totalHariIni = mysqli_fetch_assoc(mysqli_query($conn, "
            SELECT SUM(qty) as total_qty
            FROM barang_masuk
            WHERE tanggal='$today'
        "));
        ?>
        <div class="card">
            <div class="card-header">
                <form method="GET">
                    <input type="hidden" name="page" value="brgMasuk">
                    <div class="row mb-0">
                        <div class="col-md-3">
                            <label>Dari Tanggal</label>
                            <input type="date" name="dari" class="form-control" value="<?= $_GET['dari'] ?? ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Sampai Tanggal</label>
                            <input type="date" name="sampai" class="form-control" value="<?= $_GET['sampai'] ?? ''; ?>">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">

                            <button type="submit"
                                class="btn btn-primary btn-block">

                                <i class="fas fa-filter"></i>

                            </button>

                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <a href="?page=brgMasuk"
                                class="btn btn-secondary btn-block">

                                <i class="fas fa-undo-alt"></i>

                            </a>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3 d-flex align-items-end">
                            <h6>

                                Total Barang Masuk Hari Ini :

                                <span class="badge badge-success">

                                    <?= $totalHariIni['total_qty'] ?? 0; ?> Pcs

                                </span>

                            </h6>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table id="table_barang_masuk"
                    class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th>Supplier</th>
                            <th>Qty</th>
                            <th>Harga Beli</th>
                            <th>Modal/Pcs</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $where = "";
                        if (
                            isset($_GET['dari']) &&
                            isset($_GET['sampai']) &&
                            $_GET['dari'] != "" &&
                            $_GET['sampai'] != ""
                        ) {
                            $dari = $_GET['dari'];
                            $sampai = $_GET['sampai'];
                            $where = "WHERE bm.tanggal 
                            BETWEEN '$dari' 
                            AND '$sampai'";
                        }
                        $query = mysqli_query($conn, "
                            SELECT bm.*, b.nama_barang, k.nama_kategori, s.nama_supplier
                            FROM barang_masuk bm
                            JOIN barang b
                            ON bm.id_barang = b.id_barang
                            LEFT JOIN kategori k
                            ON b.id_kategori = k.id_kategori
                            LEFT JOIN supplier s
                            ON b.id_supplier = s.id_supplier
                            $where
                            ORDER BY bm.id_masuk DESC
                        ");
                        $modal = '';
                        while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= date('d-m-Y', strtotime($data['tanggal'])); ?></td>
                                <td><?= $data['nama_barang']; ?></td>
                                <td><?= $data['nama_kategori']; ?> </td>
                                <td><?= $data['nama_supplier']; ?></td>
                                <td class="text-center"><?= number_format($data['qty']); ?></td>
                                <td> Rp <?= number_format($data['harga_beli'], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($data['modal_perpcs'], 0, ',', '.'); ?></td>
                                <td><?= $data['keterangan']; ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#detail<?= $data['id_masuk']; ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- MODAL DETAIL -->
                        <?php
                            $modal .= '
                            <div class="modal fade"
                                id="detail' . $data['id_masuk'] . '">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h4 class="modal-title">
                                                Detail Barang Masuk
                                            </h4>
                                            <button type="button"
                                                class="close"
                                                data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Nama Barang</th>
                                                            <td>' . $data['nama_barang'] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Kategori</th>
                                                            <td>' . $data['nama_kategori'] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Supplier</th>
                                                            <td>' . $data['nama_supplier'] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Qty</th>
                                                            <td>' . number_format($data['qty']) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Isi Pack</th>
                                                            <td>' . $data['isi_perpack'] . '</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Stok Sebelum</th>
                                                            <td>' . number_format($data['stok_sebelum']) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Stok Sesudah</th>
                                                            <td>' . number_format($data['stok_sesudah']) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Harga Beli</th>
                                                            <td>
                                                                Rp ' . number_format($data['harga_beli'], 0, ',', '.') . '
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Modal/Pcs</th>
                                                            <td>
                                                                Rp ' . number_format($data['modal_perpcs'], 0, ',', '.') . '
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tanggal</th>
                                                            <td>
                                                                ' . date('d-m-Y', strtotime($data['tanggal'])) . '
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
                <?= $modal; ?>
            </div>
        </div>
    </div>
</section>


<script>
    $(function() {
        $("#table_barang_masuk").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "pageLength": 5,
            "lengthMenu": [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "›",
                    "previous": "‹"
                }
            }
        });
    });
</script>