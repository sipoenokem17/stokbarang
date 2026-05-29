<!-- CONTENT HEADER -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    Keranjang Transaksi
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="index.php?page=formKeluar"
                    class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i>
                    Tambah Barang
                </a>
                <a href="add/checkout.php"
                    class="btn btn-success">
                    <i class="fas fa-check mr-1"></i>
                    Checkout
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
        // ==========================
        // TOTAL
        // ==========================
        $total = mysqli_fetch_assoc(mysqli_query($conn, "
            SELECT
                COUNT(id_keranjang) as total_item,
                SUM(qty) as total_qty,
                SUM(subtotal) as total_harga,
                SUM(profit) as total_profit
            FROM keranjang 
        "));
        ?>
        <!-- INFO -->
        <div class="row">
            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>
                            <?= $total['total_item'] ?? 0; ?>
                        </h3>
                        <p>
                            Total Transaksi
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            <?= number_format($total['total_qty'] ?? 0); ?>
                        </h3>
                        <p>
                            Total Qty
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>
                            Rp <?= number_format($total['total_harga'] ?? 0, 0, ',', '.'); ?>
                        </h3>
                        <p>
                            Total Pendapatan
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>
                            Rp <?= number_format($total['total_profit'] ?? 0, 0, ',', '.'); ?>
                        </h3>
                        <p>
                            Estimasi Profit
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- TABLE -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Data Keranjang
                </h3>
            </div>
            <div class="card-body">
                <table id="table_keranjang" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th>Modal</th>
                            <th>Profit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "
                            SELECT k.*, b.nama_barang, b.stok, b.isi_perpack
                            FROM keranjang k
                            JOIN barang b
                            ON k.id_barang = b.id_barang
                            ORDER BY k.id_keranjang DESC
                        ");
                        while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $data['nama_barang']; ?></td>
                                <td class="text-center"><?= number_format($data['qty']); ?></td>
                                <td class="text-center"><?= $data['tipe']; ?></td>
                                <td>Rp <?= number_format($data['harga'], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($data['subtotal'], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($data['modal'], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($data['profit'], 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <!-- EDIT -->
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $data['id_keranjang']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- HAPUS -->
                                    <a href="add/hapus_keranjang.php?id=<?= $data['id_keranjang']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus item ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <!-- MODAL EDIT -->
                            <div class="modal fade"
                                id="edit<?= $data['id_keranjang']; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h4 class="modal-title">
                                                Edit Keranjang
                                            </h4>
                                            <button type="button"
                                                class="close"
                                                data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <form action="add/edit_keranjang.php" method="POST">
                                            <input type="hidden" name="id_keranjang" value="<?= $data['id_keranjang']; ?>">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nama Barang</label>
                                                    <input type="text" class="form-control" value="<?= $data['nama_barang']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Isi Perpack</label>
                                                    <input type="text" class="form-control" value="<?= $data['isi_perpack']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Qty(Pcs)</label>
                                                    <input type="number" name="qty" class="form-control" value="<?= $data['qty']; ?>" min="1" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Sisa Stok</label>
                                                    <input type="number" name="stok" class="form-control" value="<?= $data['stok']; ?>" min="1" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <input type="text" name="keterangan" class="form-control" value="<?= $data['keterangan']; ?>" >
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit"
                                                    class="btn btn-warning">
                                                    <i class="fas fa-save mr-1"></i>
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    $(function() {
        $("#table_keranjang").DataTable({
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