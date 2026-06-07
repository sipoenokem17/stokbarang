<?php

include "sambungkan.php";
// ==============================
// TOTAL DATA
// ==============================
// TOTAL BARANG
$totalBarang = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total
    FROM barang
    WHERE status='aktif'
"));
// TOTAL STOK
$totalStok = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(stok) as total
    FROM barang
"));
// TOTAL PROFIT
$profit = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT
        SUM(total_profit) as total_profit
    FROM transaksi
    WHERE MONTH(created_at)=MONTH(CURDATE())
    AND YEAR(created_at)=YEAR(CURDATE())

"));
// TOTAL BARANG MASUK
$totalMasuk = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(qty) as total
    FROM barang_masuk
"));

// <div class="col-12 col-sm-6 col-md-3">
// <div class="info-box mb-3">
// <span class="info-box-icon bg-success elevation-1">
// <i class="fas fa-truck"></i>
// </span>
// <div class="info-box-content">
// <span class="info-box-text">
// Barang Masuk
// </span>
// <span class="info-box-number">
// number_format($totalMasuk['total']); 
// </span>
// </div>
// </div>
// </div>

// TOTAL TRANSAKSI
$totalKeluar = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) as total
FROM transaksi
"));
// ==============================
// STOK RENDAH
// ==============================
$stokRendah = mysqli_query($conn, "
SELECT
nama_barang,
stok
FROM barang
WHERE stok <= 5
    ORDER BY stok ASC
    LIMIT 7 ");
// ==============================
// STOK BY KATEGORI
// ==============================
$kategori = mysqli_query($conn, "
    SELECT
    k.nama_kategori,
    SUM(b.stok) as total_stok,
    k.status
    FROM barang b
    LEFT JOIN kategori k
    ON b.id_kategori=k.id_kategori
    GROUP BY b.id_kategori ");
$kategoriLabel = [];
$kategoriData  = [];
while ($k = mysqli_fetch_assoc($kategori)) {
    $kategoriLabel[] = $k['nama_kategori'];
    $kategoriData[]  = $k['total_stok'];
}
// ==============================
// STOK BY SUPPLIER
// ==============================
$supplier = mysqli_query($conn, "
    SELECT
    s.nama_supplier,
    SUM(b.stok) as total_stok,
    s.status
    FROM barang b
    LEFT JOIN supplier s
    ON b.id_supplier=s.id_supplier
    GROUP BY b.id_supplier ");
$supplierLabel = [];
$supplierData  = [];
while ($s = mysqli_fetch_assoc($supplier)) {
    $supplierLabel[] = $s['nama_supplier'];
    $supplierData[]  = $s['total_stok'];
}
?>
<!-- CONTENT HEADER -->
<div class=" content-header">
    <div class="container-fluid">
        <!-- INFO BOX -->
        <div class="row mt-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1">
                        <i class="fas fa-boxes"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">
                            Total Barang
                        </span>
                        <span class="info-box-number">
                            <?= number_format($totalBarang['total']); ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-secondary elevation-1">
                        <i class="fas fa-warehouse"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">
                            Total Stok
                        </span>
                        <span class="info-box-number">
                            <?= number_format($totalStok['total']); ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">

                    <span class="info-box-icon bg-success elevation-1">
                        <i class="fas fa-chart-line"></i>
                    </span>

                    <div class="info-box-content">

                        <span class="info-box-text">
                            Total Profit Bulan ini
                        </span>

                        <span class="info-box-number">

                            Rp <?= number_format($profit['total_profit'] ?? 0, 0, ',', '.'); ?>

                        </span>

                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1">
                        <i class="fas fa-receipt"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">
                            Total Transaksi
                        </span>
                        <span class="info-box-number">
                            <?= number_format($totalKeluar['total']); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- CONTENT -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- STOK RENDAH -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-danger border-0">
                            <h3 class="card-title">
                                Stok Rendah
                            </h3>
                        </div>
                        <div class="card-body p-0" style="height:300px;">
                            <table class="table table-sm table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th width="30%" class="text-center">
                                            Stok
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($sr = mysqli_fetch_assoc($stokRendah)) { ?>
                                        <tr>
                                            <td>
                                                <?= $sr['nama_barang']; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-danger">
                                                    <?= $sr['stok']; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- CHART KATEGORI -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-info border-0">
                            <h3 class="card-title">
                                Stok by Kategori
                            </h3>
                        </div>
                        <div class="card-body" style="height:300px;">
                            <canvas id="chartKategori"
                                height="230"></canvas>
                        </div>
                    </div>
                </div>
                <!-- CHART SUPPLIER -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-secondary border-0">
                            <h3 class="card-title">
                                Stok By Supplier
                            </h3>
                        </div>
                        <div class="card-body" style="height:300px;">
                            <canvas id="chartSupplier"
                                height="230"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CHART JS -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        Chart.defaults.font.family = 'Poppins';
        Chart.defaults.font.size = 12;

        // ==========================
        // PIE KATEGORI
        // ==========================

        var kategoriCtx = document
            .getElementById('chartKategori');

        new Chart(kategoriCtx, {

            type: 'pie',

            data: {

                labels: <?= json_encode($kategoriLabel); ?>,

                datasets: [{

                    data: <?= json_encode($kategoriData); ?>,

                    backgroundColor: [

                        '#17a2b8',
                        '#28a745',
                        '#ffc107',
                        '#dc3545',
                        '#6f42c1',
                        '#fd7e14',
                        '#20c997'

                    ],

                    borderWidth: 2,
                    borderColor: '#fff'

                }]

            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            padding: 15,
                            usePointStyle: true

                        }

                    }

                }

            }

        });

        // ==========================
        // DONUT SUPPLIER
        // ==========================

        var supplierCtx = document
            .getElementById('chartSupplier');

        new Chart(supplierCtx, {

            type: 'doughnut',

            data: {

                labels: <?= json_encode($supplierLabel); ?>,

                datasets: [{

                    data: <?= json_encode($supplierData); ?>,

                    backgroundColor: [

                        '#6c757d',
                        '#17a2b8',
                        '#28a745',
                        '#ffc107',
                        '#dc3545',
                        '#6610f2',
                        '#fd7e14'

                    ],

                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 12

                }]

            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                cutoutPercentage: 60,

                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            padding: 15,
                            usePointStyle: true

                        }

                    }

                }

            }

        });
    </script>