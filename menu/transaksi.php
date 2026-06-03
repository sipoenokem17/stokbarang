<!-- CONTENT HEADER -->
<div class="content-header">
    <div class="container-fluid">
    </div>
</div>

<!-- CONTENT -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <form method="GET">
                    <input type="hidden" name="page" value="transaksi">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="mb-0 d-flex items-center">
                                Data Transaksi
                            </h3>
                        </div>
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
                            <a href="?page=transaksi"
                                class="btn btn-secondary btn-block">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table id="table_transaksi"
                    class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Total Qty</th>
                            <th>Total Belanja</th>
                            <th>Total Profit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        include "sambungkan.php";
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
                            $where = "WHERE created_at
                                      BETWEEN '$dari' 
                                      AND '$sampai'";
                        }
                        $query = mysqli_query($conn, "
                            SELECT *
                            FROM transaksi
                            $where
                            ORDER BY id_transaksi DESC
                        ");
                        $modal = '';
                        while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td>INV-<?= str_pad($data['id_transaksi'], 5, '0', STR_PAD_LEFT); ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($data['created_at'])); ?></td>
                                <td class="text-center"><?= number_format($data['total_qty']); ?></td>
                                <td>Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($data['total_profit'], 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail<?= $data['id_transaksi']; ?>" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="invoice.php?id=<?= $data['id_transaksi']; ?>"
                                        target="_blank"
                                        class="btn btn-success btn-sm" title="Print">

                                        <i class="fas fa-print"></i>

                                    </a>
                                </td>
                            </tr>
                        <?php
                            $detail = mysqli_query($conn, "
                                SELECT 
                                    dt.*,
                                    b.nama_barang,
                                    s.nama_supplier
                                FROM detail_transaksi dt
                                JOIN barang b
                                ON dt.id_barang = b.id_barang
                                LEFT JOIN supplier s
                                ON b.id_supplier = s.id_supplier
                                WHERE dt.id_transaksi = '$data[id_transaksi]'
                            ");
                            $detailRows = '';
                            while ($d = mysqli_fetch_assoc($detail)) {
                                $detailRows .= '
                                    <tr>
                                        <td>' . $d['nama_barang'] . ' </td>
                                        <td>' . $d['nama_supplier'] . '</td>
                                        <td class="text-center">' . number_format($d['qty']) . '</td>
                                        <td>' . $d['tipe'] . '</td>
                                        <td>Rp ' . number_format($d['harga'], 0, ',', '.') . '</td>
                                        <td>Rp ' . number_format($d['subtotal'], 0, ',', '.') . '</td>
                                        <td>Rp ' . number_format($d['profit'], 0, ',', '.') . '</td>
                                    </tr>
                                ';
                            }
                            $modal .= '
                            <div class="modal fade"
                                id="detail' . $data['id_transaksi'] . '"
                                tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title">
                                                Detail Transaksi
                                            </h5>
                                            <button type="button"
                                                class="close text-white"
                                                data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Barang</th>
                                                        <th>Supplier</th>
                                                        <th>Qty</th>
                                                        <th>Tipe</th>
                                                        <th>Harga</th>
                                                        <th>Subtotal</th>
                                                        <th>Profit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ' . $detailRows . '
                                                </tbody>
                                            </table>
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
        $("#table_transaksi").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "pageLength": 5,
            "lengthMenu": [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            "language": {
                "search": "Cari :",
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