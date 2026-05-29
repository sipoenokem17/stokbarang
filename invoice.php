<?php

include "sambungkan.php";

$id = $_GET['id'];

$transaksi = mysqli_query($conn, "

    SELECT *

    FROM transaksi

    WHERE id_transaksi='$id'

");

$t = mysqli_fetch_assoc($transaksi);

$detail = mysqli_query($conn, "

    SELECT

        dt.*,
        b.nama_barang

    FROM detail_transaksi dt

    JOIN barang b
    ON dt.id_barang = b.id_barang

    WHERE dt.id_transaksi='$id'

");

$total_item = mysqli_num_rows($detail);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Invoice #<?= $id; ?>
    </title>

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        body {

            background: #f4f6f9;
            padding: 30px;

        }

        .invoice-box {

            max-width: 850px;

            margin: auto;

            background: white;

            border-radius: 15px;

            overflow: hidden;

            box-shadow: 0 5px 25px rgba(0,0,0,0.08);

        }

        .invoice-header {

            background: linear-gradient(135deg,#28a745,#218838);

            color: white;

            padding: 30px;

        }

        .invoice-header h2 {

            font-weight: bold;

            margin: 0;

        }

        .invoice-body {

            padding: 30px;

        }

        .table th {

            background: #f8f9fa;

        }

        .summary-box {

            background: #f8f9fa;

            border-radius: 10px;

            padding: 20px;

        }

        .total-text {

            font-size: 24px;

            font-weight: bold;

            color: #28a745;

        }

        .badge-custom {

            font-size: 14px;

            padding: 8px 15px;

            border-radius: 30px;

        }

        .footer-note {

            text-align: center;

            padding: 20px;

            color: #777;

            border-top: 1px dashed #ccc;

        }

        @media print {

            .btn-print {

                display: none;

            }

            body {

                background: white;

                padding: 0;

            }

        }

    </style>

</head>

<body>
    <div class="invoice-box">
        <!-- HEADER -->
        <div class="invoice-header d-flex justify-content-between align-items-center">
            <div>
                <h2>
                    <i class="fas fa-store mr-2"></i>
                    Mang Brew Store
                </h2>
                <small>
                    Inventory & Sales System
                </small>
            </div>
            <div class="text-right">
                <h4>
                    INV-<?= str_pad($t['id_transaksi'], 5, '0', STR_PAD_LEFT); ?>
                </h4>
                <span class="badge badge-light badge-custom">
                    LUNAS
                </span>
            </div>
        </div>
        <!-- BODY -->
        <div class="invoice-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="mb-3">
                        Detail Transaksi
                    </h5>
                    <table>
                        <tr>
                            <td width="120">Tanggal</td>
                            <td>
                                :
                                <?= date('d M Y H:i', strtotime($t['created_at'])); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Total Qty</td>
                            <td>
                                :
                                <?= number_format($t['total_qty']); ?> Pcs
                            </td>
                        </tr>

                        <tr>
                            <td>Total Item</td>
                            <td>
                                :
                                <?= number_format($total_item); ?>
                                <!-- <?= number_format($t['total_item']); ?> -->
                            </td>
                        </tr>

                    </table>

                </div>

                <div class="col-md-6 text-right">

                    <button onclick="window.print()"
                        class="btn btn-success btn-print">

                        <i class="fas fa-print mr-1"></i>
                        Print Invoice

                    </button>

                </div>

            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <!-- <th>Tipe</th> -->
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <!-- <th>Profit</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($d = mysqli_fetch_assoc($detail)) {
                        ?>
                            <tr>

                                <td>
                                    <?= $d['nama_barang']; ?>
                                </td>

                                <td class="text-center">
                                    <?= number_format($d['qty']); ?>
                                </td>

                                <!-- <td class="text-center">
                                    <?= strtoupper($d['tipe_jual']); ?>
                                </td> -->

                                <td>
                                    Rp <?= number_format($d['harga'],0,',','.'); ?>
                                </td>   

                                <td>
                                    Rp <?= number_format($d['subtotal'],0,',','.'); ?>
                                </td>
                                <!-- <td>
                                    Rp <?= number_format($d['profit'],0,',','.'); ?>
                                </td> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- SUMMARY -->
            <div class="row justify-content-end mt-4">
                <div class="col-md-6">
                    <div class="summary-box">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th class="total-text">
                                    Total Belanja
                                </th>
                                <th class="text-right total-text">
                                    Rp <?= number_format($t['total_harga'],0,',','.'); ?>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <div class="footer-note">
            Terima kasih telah berbelanja 🙏
        </div>
    </div>
</body>
</html>